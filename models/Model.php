<?php 
namespace app\models;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public array $errors = []; 

    public function dataload(array $data)
    {
        foreach ($data as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->$key = $value; 
            }
        }
    }

    public function validate()
    {
        foreach($this->rules() as $attribute => $rules)
        {
            $value = $this->$attribute; 
            foreach($rules as $rule)
            {
                $ruleName = $rule; 
                if(is_array($ruleName))
                {
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value )
                {
                    $this->addError($attribute, self::RULE_REQUIRED); 
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addError($attribute, self::RULE_EMAIL); 
                }
                
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'] )
                {
                    $this->addError($attribute, self::RULE_MIN, $rule); 
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'] )
                {
                    $this->addError($attribute, self::RULE_MAX, $rule); 
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']} )
                {
                    $this->addError($attribute, self::RULE_MATCH); 
                }

            }
        }
        
        return false;
    }

    abstract public function rules() : array;

    public function errorMessage()
    {
        return [
            self::RULE_REQUIRED => '이 값은 필수요소입니다.',
            self::RULE_EMAIL => '이메일 형식으로 작성해주세요',
            self::RULE_MIN => '최소 {min}글자로 입력해주세요',
            self::RULE_MAX => '최대 {max}글자까지 허용합니다.',
            self::RULE_MATCH => '비밀번호가 일치하지 않습니다.'
        ]; 
    }

    public function addError(string $attriubute, string $ruleName, $rule=[])
    {
        $message = $this->errorMessage()[$ruleName] ?? ''; 
        foreach($rule as $key => $value)
        {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attriubute][] = $message;
    }

    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false; 
    }

    public function getFirstError(string $attribute)
    {
        return $this->errors[$attribute][0] ?? false; 
    }
}