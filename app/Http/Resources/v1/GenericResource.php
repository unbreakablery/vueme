<?php

namespace App\Http\Resources\v1;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericResource extends JsonResource
{
    private $fields;

    public function __construct($query, $fields = [])
    {
        $this->fields = $fields;
        parent::__construct($query);
    }

    public function setFields(array $fields){
        $this->fields = $fields;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $data = [];

        if (!$this->fields) {

            $data = \get_object_vars($this)['resource'];
            $data = $data->toArray();

            if (isset($data['pivot'])) {
                unset($data['pivot']);
            }

            return $data;

        }

        foreach ($this->fields as $key => $value) {

            if(\is_array($value)){
                try {
                    if ($this->$key instanceof Collection) {
                        $data[$key] = new GenericResourceCollection($this->$key, $value);
                    } else if (\gettype($this->$key) === 'object') {
                        $data[$key] = new GenericResource($this->$key, $value);
                    }
                    else{
                        foreach ($value as $key2 => $value2) {
                            if(\gettype($this->{$key2}) == 'string'){
                               $data[$value2] = $this->{$key2};
                            }
                            else if ($this->$key2 instanceof Collection) {
                                $data[$value2] = new GenericResourceCollection($this->$key2);
                            } else if (\gettype($this->$key2) === 'object') {
                                $data[$value2] = new GenericResource($this->$key2);
                            }
                           }
                    }

                } catch (\Throwable $th) {

                }
                
            }
            else{
                try {

                    $newKey = !\is_numeric($key) ? $key : $value;

                    if($value == 'image'){
                        $data[$newKey] = new GenericResource($this->{$value},['id', 'url']);
                    }
                    else if ($this->$value instanceof Collection) {
                        $data[$newKey] = new GenericResourceCollection($this->$value);
                    } else if (\gettype($this->$value) === 'object') {
                        $data[$newKey] = new GenericResource($this->$value);
                    } else if ($this->$value || method_exists($this->resource, $value) || property_exists($this->resource, $value)) {
                        $data[$newKey] = $this->$value;
                    }

                } catch (\Throwable $th) {

                } 
            }                        
        }
        return $data ?? null;
    }
}
