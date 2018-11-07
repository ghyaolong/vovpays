<?php

namespace App\Services;
use App\Repositories\AdminsRepository;

class CheckUniqueService
{
    protected $adminsRepository;

    public function __construct(AdminsRepository $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
    }


    /**
     * 唯一验证
     * @param string $table_name
     * @param string $field
     * @param string $value
     * @param int|null $id
     * @return bool
     */
    public function check(string $table_name, string $field, string $value, int $id = null )
    {

        switch ($table_name)
        {
            case 'admins':

                if($id)
                {
                    if($field == 'email')
                    {
                        $result = $this->adminsRepository->findEmailNotId($value, $id);
                    }else if($field == 'username'){
                        $result = $this->adminsRepository->findUsernameNotId($value, $id);
                    }else if($field == 'phone'){
                        $result = $this->adminsRepository->findPhoneNotId($value, $id);
                    }
                }else{
                    if($field == 'email')
                    {
                        $result = $this->adminsRepository->findEmail($value);
                    }else if($field == 'username'){
                        $result = $this->adminsRepository->findUsername($value);
                    }else if($field == 'phone'){
                        $result = $this->adminsRepository->findPhone($value);
                    }
                }

                break;
            default :
                $result = '';
        }
        return $result = $result ? false : true;
    }

}
