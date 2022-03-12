<?php

namespace App\Models;

use IDAnalyzer\Vault;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $table = 'user_document';

    protected $fillable = [
        'type', 'user_id', 'vault',
    ];

    public function file()
    {
        return $this->morphOne('App\Models\File', 'fileable');
    }

    public function getVaultInfo(){
        if ($this->vault) {
            $vault = new Vault(env('idanalyzer_key'), 'US');
            $result = $vault->get($this->vault);
            return $result['data'] ?? false;
        }
        return false;
    }

    public function delete(array $data = [])
    {

        if ($this->file) {
            $this->file->delete();
        }
        if ($this->vault) {

            $vault = new Vault(env('idanalyzer_key'), 'US');
            $vault->delete($this->vault);
        }
        return parent::delete();
    }
}
