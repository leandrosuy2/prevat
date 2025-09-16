<?php

namespace App\Http\Controllers;

use App\Repositories\Site\RegistrationRepository;
use Illuminate\Http\Request;

class UserVerifyController extends Controller
{
    public function verifyAccount($token)
    {
        $registrationRepository = new RegistrationRepository();
        $registrationReturnDB = $registrationRepository->verifyAccount($token);

        if($registrationReturnDB['status'] == 'success') {
            return redirect()->route('admin.login')->with($registrationReturnDB['status'], $registrationReturnDB['message']);
        } else if ($registrationReturnDB['status'] == 'error') {
            return redirect()->route('admin.login')->with($registrationReturnDB['status'], $registrationReturnDB['message']);
        }
    }
}
