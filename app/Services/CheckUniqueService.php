<?php

namespace App\Services;

use App\Repositories\AccountPhoneRepository;
use App\Repositories\AdminsRepository;
use App\Repositories\UsersRepository;

class CheckUniqueService
{
    protected $adminsRepository;
    protected $usersRepository;
    protected $accountPhoneRepository;

    public function __construct(AdminsRepository $adminsRepository, UsersRepository $usersRepository, AccountPhoneRepository $accountPhoneRepository)
    {
        $this->adminsRepository = $adminsRepository;
        $this->usersRepository = $usersRepository;
        $this->accountPhoneRepository = $accountPhoneRepository;
    }


    /**
     * 唯一验证
     * @param string $table_name
     * @param string $field
     * @param string $value
     * @param int|null $id
     * @return bool
     */
    public function check(string $table_name, string $field, string $value, int $id = null)
    {
        switch ($table_name) {
            case 'admins':
                $result = $this->adminsRepository->searchOne($field, $value, $id);
                break;

            case 'users':
                $result = $this->usersRepository->searchOne($field, $value, $id);
                break;

            case 'account_phones':
                $result = $this->accountPhoneRepository->searchOne($id, $value);
                break;

            default :
                return false;
        }

        return $result = $result ? false : true;
    }

}
