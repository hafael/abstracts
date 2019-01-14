<?php

namespace Hafael\Abstracts\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{

    protected $requestRules = [
        //
    ];

    protected $requestMessages = [
        //
    ];

    protected $attributeMap = [
        //
    ];

    protected $availableAttributes = [
        //
    ];

    protected $attributeValues = [
        //
    ];

    protected $nullableAttributes = [
        //
    ];

    protected $attributeClearValues = [
        //
    ];

    protected $attributeParseDates = [
        //
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = $this->requestRules;

        return $rules;

    }

    public function getAvailableAttributes()
    {
        return $this->availableAttributes;
    }

    /**
    * Limpa os campos e prepara para a validação
    */
    public function prepareForValidation()
    {

        //Limpa e remove qualquer atributo nao mapeado.
        $this->clearNullableAndEmptyValues();
        $this->clearSpecialCharsInputs();
        $this->parseDates();

    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return $this->requestMessages;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            $this->transformInputValue();
            $this->sanitize();
        });
    }


    /**
     * Transforma o input da requisição, renomeando p/ o
     * atributo correto da classe.
     */
    public function sanitize()
    {
        $inputs = $this->only($this->availableAttributes);
        $data = [];


        foreach($inputs as $key => $value){

            
            if(array_key_exists($key, $this->attributeMap)){

                if(is_array($this->attributeMap[$key])){

                    $subArrNotEmpty = array_filter($this->input($key), function($item){
                        return !empty($item);
                    });

                    foreach($subArrNotEmpty as $subKey => $value) 
                    {
                        
                        $value = $this->input($key)[$subKey];
                        
                        $data[$key][$this->attributeMap[$key][$subKey]] = $value;

                        $this->offsetSet($this->attributeMap[$key][$subKey], $value);
                    }
                }else {
                    $data[$this->attributeMap[$key]] = $value;
                    $this->offsetSet($this->attributeMap[$key], $value);
                }

            }else{
                $data[$key] = $value;
                $this->offsetSet($key, $value);
            }
        }

        $this->replace($data);

        unset($data, $inputs);
    }


    /*
     * Transforma o valor dos inputs
     * */
    public function transformInputValue()
    {
        $inputs = $this->only($this->availableAttributes);

        $data = [];

        foreach($inputs as $key => $value){
            //if($value !== null && trim($value) !=='')

            if(!is_array($value) && array_key_exists($key, $this->attributeValues)){
                $attr = $this->attributeValues[$key];
                if(array_key_exists((string) $this->input($key), $attr)){
                    $data[$key] = $attr[$this->input($key)];
                }
            }else{
                $data[$key] = $value;
            }

        }

        $this->replace($data);

        unset($data, $inputs);
    }

    /*
     * Limpa caracteres inválidos dos inputs baseado em
     * expressoes regulares
     * */

    public function clearSpecialCharsInputs()
    {
        $inputs = $this->only($this->availableAttributes);


        $data = [];
        foreach($inputs as $key => $value){

            if(array_key_exists($key, $this->attributeClearValues)) {

                if(is_array($this->attributeClearValues[$key])) {

                    foreach($inputs[$key] as $subKey => $subValue) {

                        if(array_key_exists($subKey, $this->attributeClearValues[$key])){

                            $value = [ $subKey => preg_replace($this->attributeClearValues[$key][$subKey], '', trim($subValue)) ];

                        }else {

                            $value = [ $subKey => $subValue ];
                        }

                        $old = !empty($data[$key]) ? $data[$key] : [];

                        $data[$key] = array_merge($old, $value);

                        $this->offsetSet($key, [$key => $data[$key]]);

                    }

                } else {
                    $data[$key] = preg_replace($this->attributeClearValues[$key], '', trim($value));

                    $this->offsetSet($key, $data[$key]);
                }

            } else {
                $data[$key] = $value;
                $this->offsetSet($key, $value);
            }


        }

        $this->replace($data);

        unset($data, $inputs);
    }


    /*
     * Traduz as datas p/ o formato do banco
     * */

    public function parseDates()
    {
        $inputs = $this->only($this->availableAttributes);

        $data = [];
        foreach($inputs as $key => $value){
            //if($value !== null && trim($value) !=='')
            if(!is_array($value) && array_key_exists($key, array_flip($this->attributeParseDates))){

                $data[$key] = Carbon::parse($value);

            }else{
                $data[$key] = $value;
            }
        }
        $this->replace($data);
        unset($data, $inputs);
    }

    public function clearNullableAndEmptyValues()
    {

        $inputs = $this->only(array_flip(array_except(array_flip($this->availableAttributes), $this->nullableAttributes)));

        $data = [];
        foreach($inputs as $key => $value){
            if((!is_array($value) && !is_null($value)) || array_has($this->nullableAttributes, [$key])){
                $data[$key] = $value;
                $this->offsetSet($key, $value);
            }else if(!empty($value) && is_array($value)) {
                $data[$key] = $value;
                $this->offsetSet($key, $value);
            }
            //$this->offsetSet($key, $value);
        }


        $data = array_merge($data, $this->only($this->nullableAttributes));

        $this->replace($data);
        unset($data, $inputs);

    }

    public function requestParams($keys = null)
    {

        $attrMap = array_values(array_filter($this->attributeMap, function($item){
            return !is_array($item);
        }));

        //atributos que nao contam
        $attrs = array_merge(array_except($attrMap, $this->availableAttributes), $this->availableAttributes);

        return $this->only(empty($keys) ? $attrs : $keys);
    }


}