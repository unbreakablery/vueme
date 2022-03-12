<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;



class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        /* $context = stream_context_create(array('ssl'=>array(
            'verify_peer' => false,
            "verify_peer_name"=>false,
        )));
        libxml_set_streams_context($context);*/

        $models = User::where('role_id', 1)->where('email_validated', 1)->where('test_user', 0)->where('fraud', 0)->get();

        $date = new \DateTime();
        $dateOK = $date->format('Y-m-d');
        // Open and parse the XML file
        $xml = simplexml_load_file(config('app.url') . "/sitemap.xml");

        $xml_string = file_get_contents(config('app.url') . "/sitemap.xml");



        foreach ($models as $psychic) {

            $psychic_link = $psychic->userProfile()->first()->profile_link;

            if (strpos($xml_string, $psychic_link) == false) {
                echo "Record was added - $psychic_link ";
                // Create a child in the first topic node
                $child = $xml->addChild("url");
                // Add the text attribute
                $child->addChild("loc", config('app.url') . "/" . $psychic_link . "/");
                $child->addChild("lastmod", "$dateOK");
                $child->addChild("changefreq", "daily");
                $child->addChild("priority", "1.0");
            }
        }
        $xml->asXML("public/sitemap.xml");
    }
}
