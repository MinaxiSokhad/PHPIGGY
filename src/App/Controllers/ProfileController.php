<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService,ReceiptService,ProfileService,UserService,ValidatorService};

class ProfileController
{
  public function __construct(
    private TemplateEngine $view,
    private TransactionService $transactionService,
    private ReceiptService $receiptService,
    private ProfileService $profileService,
    private UserService $userService,
    private ValidatorService $validatorService
  ) {
  }
  public function profileView(array $params){
    
    $profile = $this->profileService->getUserProfile((int) $params['user']);
    // dd($profile);
    if(!$profile){
        redirectTo('/');
    }

    echo $this->view->render("/profile.php",[
        'profile' => $profile
    ]);
    
  }
  public function updateProfile(){
    $this->validatorService->validateProfile($_POST);
   $this->userService->isEmailTakenProfile($_POST['email'],$_SESSION['user']);
    $this->profileService->updateData($_POST);
    redirectTo('/');
  }
  
}