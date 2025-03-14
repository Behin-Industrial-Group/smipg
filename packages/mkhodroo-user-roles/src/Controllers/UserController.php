<?php

namespace Mkhodroo\UserRoles\Controllers;

use App\Models\MethodsModel;
// use Auth;
use App\CustomClasses\Access;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomStringController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\UserRoles\Controllers\GetRoleController;
use Mkhodroo\UserRoles\Models\Method;
use Mkhodroo\UserRoles\Models\User;
use Illuminate\Support\Str; 

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);

    }

    public function index($id)
    {
        if($id == 'all'):
            $users = User::get();
            return view('URPackageView::user.all')->with(['users' => $users]);
        else:

            return view('URPackageView::user.edit')->with([
                'user' => User::find($id),
                'roles' => GetRoleController::getAll()
            ]);
        endif;
    }

    public function AccessReg(Request $request, $id)
    {
        Access::check('user_show_all');
        $methods = MethodsModel::get()->toArray();

        foreach($methods as $method)
        {
            $name = $method['name'];
            if(isset($request->$name)):
                Access::set($id,$method['name']);

            else:
                Access::unset($id,$method['name']);
            endif;
        }
        return redirect()->back();
    }

    public function ChangePass(Request $request, $id)
    {
        User::where('id', $id)->update([ 'password' => Hash::make($request->pass) ]);
        return redirect()->back();
    }

    function changePMUsername(Request $r, $id) {
        User::where('id', $id)->update(['pm_username' => $r->pm_username]);
        return redirect()->back();
    }

    public function ChangeIp(Request $r, $user_id)
    {
        User::where('id',$user_id)->update([ 'valid_ip' => $r->valid_ip ]);
        return redirect()->back();
    }

    public function changeShowInReport(Request $r, $id){
        if(isset($r->showInReport))
            $showInReport = true;
        else
            $showInReport = false;
        User:: where('id', $id)->update([ 'showInReport' => $showInReport ]);
        return redirect()->back();
    }

    public static function create_api_token(User $user)
    {
        $token = RandomStringController::Generate(32);
        $user->api_token = $token;
        $user->save();
        return $user;
    }

    public static function getByValidationLink($validation_link)
    {
        return User::where('validation_link', $validation_link)->first();
    }

    public static function createQrCode($id)
    {
        $user = User::find($id);
        if($user->validation_link){
            return redirect()->back()->with('error', trans('Code is generated previously'));
        }
        $validation_string = Str::random(10);
        $qrCodeFilePath = storage_path('app/users/'.$validation_string . '.png');
        $link = route('users.show', $validation_string);

        $qrCodes['simple'] = QrCode::format('png')->size(300)->generate($link);
        $file = fopen($qrCodeFilePath, 'wb');
        fwrite($file, $qrCodes['simple']);
        fclose($file);
        $user->validation_link = $validation_string;
        $user->save();

        return redirect()->back();
    }

    public function show($validation_link)
    {
        return 'asd';
        $user = self::getByValidationLink($validation_link);
        return view('URPackageView::user.show', compact('user'));
    }

}
