<?php

namespace App\Http\Controllers;

use App\Events\CreateProviderProcessed;
use App\Events\DeletedProviderProcessed;
use App\Http\Requests\ProviderEditRequest;
use App\Http\Requests\ProviderRegisteringRequest;
use App\Models\Province;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        View::share('title', 'Home');
        $providers=ServiceProvider::all()->toArray();
        // foreach($providers as $key => $provider){
        //     $providers[$key]['address']=Province::where('code', $provider['address'])->first()->name;
        // }
        return view('admin.index')->with([
            'providers'=>$providers
            ]);
    }
    public function provider_create()
    {
        View::share('title', 'ProviderCreation');
        return view('admin.provider.create');
    }
    public function provider_store(ProviderRegisteringRequest $request)
    {
        $toInsert=$request->only('phone_number','name','address');
        $toInsert['employer_id']=User::query()->where('email', $request->email)->first()->id;
        CreateProviderProcessed::dispatch($toInsert['employer_id']);
        return ServiceProvider::create($toInsert);

    }
    public function provider_index()
    {
        View::share('title', 'Home');
        $providers=ServiceProvider::all();
        $providers->append('address_name');
        return view('admin.provider.index')->with([
            'providers'=>$providers->toArray()
            ]);
    }
    public function provider_edit(int $id)
    {
        View::share('title', 'ProviderEdition');
        $provider=ServiceProvider::find($id);
        $provider->append('email');
       // $provider->email=User::find($provider->employer_id)->email;
        return view('admin.provider.edit',['provider'=>$provider]);
    }
    public function provider_destroy(int $id)
    {
        DeletedProviderProcessed::dispatch($id);
        ServiceProvider::destroy($id);
        return redirect()->route('admin.provider.index'); 
    }
    public function provider_update(int $id,ProviderEditRequest $request)
    {
        $toUpdate=ServiceProvider::find($id);
        $toUpdate->employer_id=User::query()->where('email', $request->email)->first()->id;
        $toUpdate->phone_number=$request->phone_number;
        $toUpdate->name=$request->name;
        $toUpdate->address=$request->address;
        $toUpdate->save();
        return $toUpdate;
    }
}
