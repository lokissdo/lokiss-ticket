<?php

namespace App\Http\Controllers;

use App\Constants\ItemsPerPage;
use App\Enums\UserRoleEnum;
use App\Events\CreateProviderProcessed;
use App\Events\DeletedProviderProcessed;
use App\Http\Requests\ProviderEditRequest;
use App\Http\Requests\ProviderRegisteringRequest;
use App\Http\Requests\StationRegisteringRequest;
use App\Models\Province;
use App\Models\ServiceProvider;
use App\Models\Station;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        View::share('title', 'Home');
        $providers = ServiceProvider::all()->toArray();
        // foreach($providers as $key => $provider){
        //     $providers[$key]['address']=Province::where('code', $provider['address'])->first()->name;
        // }
        return view('admin.index')->with([
            'providers' => $providers
        ]);
    }
    public function user_index(Request $request)
    {
        $itemsPerPage = ItemsPerPage::USER;
        $sortCol = $request->sortCol ?? 'id';
        $sortType = $request->sortType ?? 'asc';
        $searchCol = $request->searchCol ?? 'name';
        $searchVal = $request->searchVal ?? '';

        $offset = $request->pageNum ? ($request->pageNum - 1) * $itemsPerPage : 0;
        $limit = $itemsPerPage;


        $query = User::where($searchCol, 'like', '%' . $searchVal . '%')
            ->orderBy($sortCol, $sortType);
        if (isset($request->address) && $request->address != 'null')  $query = $query->where('address', $request->address);
        if (isset($request->address2) && $request->address2 != 'null')  $query = $query->where('address2', $request->address2);
        if (isset($request->role) && $request->role != 'null')  $query = $query->where('role', $request->role);


        $totalPage=(!empty($request->isFilter)||!isset($request->isFilter))?ceil(($query->count()) / $itemsPerPage):-1;

        $users = $query->offset($offset)->limit($limit)->get();

        $users->append('address_name');
        $users->append('role_name');


        if (!empty($request->isAPI)) return json_encode([
            'users' => $users,
            'totalPage' => $totalPage
        ]);
        View::share('title', 'UsersList');
        return view('admin.user.index', [
            'users' => $users,
            'total_page' => $totalPage,
            'roles'=>UserRoleEnum::asArray()
        ]);
    }



    //provider
    public function provider_create()
    {
        View::share('title', 'ProviderCreation');
        return view('admin.provider.create');
    }
    public function provider_store(ProviderRegisteringRequest $request)
    {
        $toInsert = $request->only('phone_number', 'name', 'address');
        $toInsert['employer_id'] = User::query()->where('email', $request->email)->first()->id;
        CreateProviderProcessed::dispatch($toInsert['employer_id']);
        return ServiceProvider::create($toInsert);
    }
    public function provider_index()
    {
        View::share('title', 'Home');
        $providers = ServiceProvider::all();
        $providers->append('address_name');
        return view('admin.provider.index')->with([
            'providers' => $providers->toArray()
        ]);
    }
    public function provider_edit(int $id)
    {
        View::share('title', 'ProviderEdition');
        $provider = ServiceProvider::find($id);
        $provider->append('email');
        return view('admin.provider.edit', ['provider' => $provider]);
    }
    public function provider_destroy(int $id)
    {
        try {
            DeletedProviderProcessed::dispatch($id);
            ServiceProvider::destroy($id);
        } catch (Exception $e) {
            return back()->withError('Phải xóa tất cả hoạt động và tài sản của nhà xe trước'); //$e->getMessage()
        }
        return redirect()->route('admin.provider.index');
    }
    public function provider_update(int $id, ProviderEditRequest $request)
    {
        $toUpdate = ServiceProvider::find($id);
        $newuser = User::query()->where('email', $request->email)->first();
        $olduser = User::find($toUpdate->employer_id);
        if ($newuser != $olduser) {
            $newuser->role = UserRoleEnum::EMPLOYER;
            $newuser->save();
            $olduser->role = UserRoleEnum::PASSENGER;
            $olduser->save();
        }
        $toUpdate->employer_id = $newuser->id;
        $toUpdate->phone_number = $request->phone_number;
        $toUpdate->name = $request->name;
        $toUpdate->address = $request->address;
        $toUpdate->save();
        return $toUpdate;
    }


    //station
    public function station_index()
    {
        View::share('title', 'Station');
        $stations = Station::all();
        return view('admin.station.index')->with([
            'stations' => $stations->toArray()
        ]);
    }
    public function station_create()
    {
        View::share('title', 'StationCreation');
        return view('admin.station.create');
    }
    public function station_store(StationRegisteringRequest $request)
    {
        $toInsert = $request->only('address2', 'name', 'address');
        return Station::create($toInsert);
    }
    public function station_destroy(int $id)
    {
        try {
            Station::destroy($id);
        } catch (Exception $e) {
            return back()->withError('Không thể xóa bến này vì đã được chọn trong lịch trình'); //$e->getMessage()
        }
        return redirect()->route('admin.station.index');
    }
}
