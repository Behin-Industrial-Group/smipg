@extends('layouts.app')

@section('title')
    کاربران
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="all" class="btn btn-info">Back To List</a>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">

                </div>

                <div class="box-body">
                    <table class="table">
                        <tr>
                            <th>شناسه</th>
                            <td>{{$user->id}}</td>
                        </tr>
                        <tr>
                            <th>نام</th>
                            <td>{{$user->display_name}}</td>
                        </tr>
                        <tr>
                            <th>نام کاربری</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>ایمیل</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <form method="post" action="{{ route('change-user-ip', ['id'=> $user->id]) }}">
                                @csrf
                                <td>valid ip:<input type="text" name="valid_ip" id="" value="{{ $user->valid_ip }}"></td>
                                <td><input type="submit" value="ثبت ip" name="" id=""></td>
                            </form>
                        </tr>
                        <tr>
                            <form method="post" action="{{ route('change-pm-username', ['id'=> $user->id]) }}">
                                @csrf
                                <td>نام کاربری Process Maker<input type="text" name="pm_username" id="" value="{{ $user->pm_username }}"></td>
                                <td><input type="submit" value="تغییر نام کاربری PM" name="" id=""></td>
                            </form>
                        </tr>
                        <tr>
                            <form method="post" action="{{$user->id}}/changepass">
                                @csrf
                                <input type="password" name="pass">
                                <input type="submit" value="تغییر رمز">
                            </form>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <form method="post" action="{{$user->id}}/changeShowInReport">
                        @csrf
                        <input type="checkbox" name="showInReport" class="" <?php if($user->showInReport == 1) echo "checked" ?>>نمایش در گزارشها
                        <input type="submit" class="btn btn-success" value="ثبت">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h3>دسترسی ها</h3>
                </div>

                <div class="box-body">
                    <button class="" id="check_all">انتخاب همه</button>
                    <form class="form-horizontal" method="post" action="" id="role-table">
                        @csrf
                       <input type="text" name="user_id" id="" value="{{ $user->id }}">
                            <select name="role_id" id="">
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}" @if($user->role_id == $role->id) {{ 'selected' }}   @endif>{{$role->name}}</option>
                                @endforeach
                            </select>
                    </form>

                    <button onclick="change_role()">change role</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        function change_role(){
            send_ajax_request(
                "{{ route('role.changeUserRole') }}",
                $('#role-table').serialize(),
                function(response){
                    console.log(response);
                }
            )
        }
        $("#check_all").on('click',function(){
            $('#access_tbl input:checkbox').prop('checked', 'true');
        });
    </script>
@endsection
