<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\UserDetails;
use App\Models\User;
use App\Models\UserExperiences;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        try
        {
            $user = $request->user()::join('user_details as ud', 'users.id', 'ud.user_id')
                ->where('user_id', $request->user()->id)
                ->first();
            $profile_image = "";
            
            if($user->profile_image_path)
            {
                $profile_image = $this->getProfileImage($request);
            }
    
            return response([
                'user'=>$user,
                'profile_image' => $profile_image
            ]);
        }
        catch(e)
        {
            return response(['error' => e], 500);
        }
    }

    public function updateBasicDetails(Request $request)
    {
        try
        {
            User::find($request->user()->id)->update(['name'=>$request->name]);

            $tempData = [
                'address'               => $request->address,
                'dob'                   => $request->dob,
                'mobile'                => $request->mobile,
                'alternate_mobile'      => $request->alternate_mobile,
                'linkedin_link'         => $request->linkedin_link,
                'github_link'           => $request->github_link
            ];

            if($request->proile_image)
            {
                $imagePathForDb = $this->uploadProfileImage($request);
                if($imagePathForDb) 
                {
                    $tempData = [
                        'address'               => $request->address,
                        'dob'                   => $request->dob,
                        'mobile'                => $request->mobile,
                        'alternate_mobile'      => $request->alternate_mobile,
                        'linkedin_link'         => $request->linkedin_link,
                        'github_link'           => $request->github_link,
                        'profile_image_path'    => $imagePathForDb
                    ];
                }
                
            }

            UserDetails::where('user_id', $request->user()->id)
                            ->update($tempData);
    
            return redirect('/api/user');
        }
        catch(e)
        {
            return response(['error' => e], 500);
        }
    }

    public function uploadProfileImage(Request $request)
    {
        $basePath = env('UPLOADED_FILES').DIRECTORY_SEPARATOR."User";
        if(!file_exists($basePath)){
            mkdir($basePath);
        }
        
        $basePath = env('UPLOADED_FILES').DIRECTORY_SEPARATOR."User".DIRECTORY_SEPARATOR.$request->user()->id;
        if(!file_exists($basePath)){
            mkdir($basePath);
        }

        $target_file =$basePath.DIRECTORY_SEPARATOR.basename($_FILES["proile_image"]["name"]);

        if(move_uploaded_file($_FILES["proile_image"]["tmp_name"], $target_file)) {
            $imageSize=$_FILES['proile_image']['size'];
            $imageName=basename($_FILES["proile_image"]["name"]);
            $imagePathForDb="User".DIRECTORY_SEPARATOR.$request->user()->id.DIRECTORY_SEPARATOR.basename($_FILES["proile_image"]["name"]);
            return $imagePathForDb;
        }
        return "";
        
    }

    public function getProfileImage(Request $request)
    {

        $pathFromDb = UserDetails::where('user_id', $request->user()->id)->select('profile_image_path')->get();
        $imgPath = env('UPLOADED_FILES').DIRECTORY_SEPARATOR.$pathFromDb[0]['profile_image_path'];

        if(file_exists($imgPath))
        {
            $type = pathinfo($imgPath, PATHINFO_EXTENSION);
            $data = file_get_contents($imgPath);
            $base64 = 'data:face_image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }
        else
        {
            return "";
        }
    }

    public function getExperiences(Request $request)
    {
        try
        {
            $experiences = UserExperiences::where('user_id', $request->user()->id)
                                            ->orderBy('updated_at', 'desc')
                                            ->get();
            return response(['experiences' =>$experiences]);
        }
        catch(e)
        {
            return response(['error'=>e], 500);
        }
    }

    public function addExperience(Request $request)
    {
        try
        {
            if($request->currently_working)
            {
                UserExperiences::create([
                    'user_id'           => $request->user()->id,
                    'job_title'         => $request->job_title,
                    'company_name'      => $request->company_name,
                    'start_date'        => $request->start_date,
                    'currently_working' => $request->currently_working
                ]);
            }
            else
            {
                UserExperiences::create([
                    'user_id'           => $request->user()->id,
                    'job_title'         => $request->job_title,
                    'company_name'      => $request->company_name,
                    'start_date'        => $request->start_date,
                    'end_date'          => $request->end_date,
                    'currently_working' => $request->currently_working
                ]);
            }

            return redirect('/api/user/getExperiences');
        }
        catch(e)
        {
            return response(['error'=>e], 500);
        }
    }

    public function updateExperience(Request $request)
    {
        try
        {
            if($request->currently_working)
            {
                UserExperiences::find($request->id)
                                    ->update([
                                        'job_title'         => $request->job_title,
                                        'company_name'      => $request->company_name,
                                        'start_date'        => $request->start_date,
                                        'end_date'          => null,
                                        'currently_working' => $request->currently_working
                                    ]);
            }
            else
            {
                UserExperiences::find($request->id)
                                    ->update([
                                        'job_title'         => $request->job_title,
                                        'company_name'      => $request->company_name,
                                        'start_date'        => $request->start_date,
                                        'end_date'          => $request->end_date,
                                        'currently_working' => $request->currently_working
                                    ]);
            }
    
            return redirect('/api/user/getExperiences');
        }
        catch(e)
        {
            return response(['error'=>e], 500);
        }
    }

    public function deleteExperience(Request $request)
    {
        try
        {
            UserExperiences::find($request->id)->delete();
            return redirect('/api/user/getExperiences');
        }
        catch(e)
        {
            return response(['error'=>e], 500);
        }
    }
}
