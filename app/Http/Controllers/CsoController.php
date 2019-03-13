<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Cso;
use App\Branch;
use Auth;
use DB;

class CsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param Request Keyword
     */
    /*Function enkripsi & dekripsi nomor telpon*/
    function Encr(string $x)
    {
        $pj = strlen($x);
        $hasil = '';
        for($i=0; $i<$pj; $i++)
        {
            $ac = ord(substr($x, $i, 1));
            $hs = $ac*2-4;
            if($hs > 255)
            {
                $hs = $hs-255;
            }
            $hasil .= chr($hs);
        }
        return $hasil;
    }

    public static function Decr(string $x)
    {
        $pj = strlen($x);
        $hasil = '';
        for($i=0; $i<$pj; $i++)
        {
            $ac = ord(substr($x, $i, 1))+4;
            if($ac % 2 == 1)
            {
                $ac+=255;
            }
            $hs = $ac/2;
            
            $hasil .= chr($hs);
        }
        return $hasil;
    }

    public function index(Request $request)
    {
        //FOR ENCRYPT PHONE AT FIRST IMPORT THE DATABASE
        // for ($i = 1; $i<=301; $i++)
        // {
        //     $cso = DB::table('csos')->where('id', $i)->first();
        //     DB::table('csos')
        //     ->where('id', $i)
        //     ->update(['phone' => $this->Encr($cso->phone)]);
        // }

        $user = Auth::user();

        if($user->can('all-branch-cso'))
        {
            if($user->can('all-country-cso'))
            {
                $csos = Cso::when($request->keyword, function ($query) use ($request) {
                    $query->where('csos.code', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true)
                        ->orWhere('csos.address', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true)
                        ->orWhere('csos.no_rekening', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true)
                        ->orWhere('csos.phone', 'like', "%{$this->Encr($request->keyword)}%")
                        ->where('csos.active', true)
                        // ->orWhere('csos.province', 'like', "%{$request->keyword}%")
                        // ->where('csos.active', true)
                        // ->orWhere('csos.district', 'like', "%{$request->keyword}%")
                        // ->where('csos.active', true)
                        ->orWhere('csos.registration_date', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true)
                        ->orWhere('branches.name', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keyword}%")
                        ->where('csos.active', true);
                })->where('csos.active', true)
                ->join('branches', 'csos.branch_id', '=', 'branches.id')
                ->select('csos.*')
                ->paginate(10);

                $csos->appends($request->only('keyword'));
            }
            else
            {
                $csos = Cso::when($request->keyword,function ($query) use ($request, $user){
                    $query->where('csos.code', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.address', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.phone', 'like', "%{$this->Encr($request->keyword)}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.province', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.district', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.registration_date', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('branches.name', 'like', "%{$request->keyword}%")
                        ->where([
                            ['csos.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })->where([
                    ['csos.active', true],
                    ['branches.country', $user->branch['country']]
                ])
                ->join('branches', 'csos.branch_id', '=', 'branches.id')
                ->select('csos.*')
                ->paginate(10);

                $csos->appends($request->only('keyword'));
            }
        }
        else
        {
            $csos = Cso::when($request->keyword,function ($query) use ($request, $user){
                $query->where('code', 'like', "%{$request->keyword}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ])
                        ->orWhere('name', 'like', "%{$request->keyword}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ])
                        ->orWhere('address', 'like', "%{$request->keyword}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ])
                        ->orWhere('phone', 'like', "%{$this->Encr($request->keyword)}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ])
                        ->orWhere('province', 'like', "%{$request->keyword}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ])
                        ->orWhere('district', 'like', "%{$request->keyword}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ])
                        ->orWhere('registration_date', 'like', "%{$request->keyword}%")
                        ->where([
                            ['active', true],
                            ['branch_id', $user->branch_id]
                        ]);
            })->where([
                ['active', true],
                ['branch_id', $user->branch_id]
            ])
            ->paginate(10);
        }
        $branches = Branch::orderBy('name')->pluck('name', 'id');
        // $branches = Branch::where([['country', $user->branch['country']],['active', true]])->get();
        return view('cso', compact('csos', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'unregistration_date' => [
                'nullable',
                'after:registration_date',
            ],
            'phone' => [
                'required',
                Rule::unique('csos')->where('active', 1),
            ],
            'no_rekening' => [
                Rule::unique('csos')->where('active', 1),
            ],
            'branch' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $count = Cso::all()->count();
            $count++;

            $data = $request->only('code', 'registration_date', 'unregistration_date', 'name', 'address', 'phone');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);
            $branch = Branch::find($request->get('branch'));
            $name = strtoupper(substr(str_slug($request->get('name'), ""), 0, 3));

            for($i=strlen($count); $i<4; $i++)
            {
                $count = "0".$count;
            }
            $code = $branch->code . $name . $count;
            // KODE SEMENTARA CSO

            $data['code'] = $code;
            $data['branch_id'] = $request->get('branch');

            if($request->get('komisi') != null)
            {
                $data['komisi'] = $request->get('komisi');
            }
            if($request->get('no_rekening') != null)
            {
                $data['no_rekening'] = $request->get('no_rekening');
            }

            Cso::create($data); //INSERT INTO DATABASE (with created_at)

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($this->Encr($request->phone))]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'unregistration_date' => [
                'nullable',
                'after:registration_date',
            ],
            'phone' => [
                'required',
                Rule::unique('csos')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'no_rekening' => [
                Rule::unique('csos')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'branch' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
            $data = $request->only('registration_date', 'unregistration_date', 'name', 'address', 'phone', 'komisi', 'no_rekening', 'province', 'district');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);
            $data['branch_id'] = $request->get('branch');

            // DB::table('csos')
            //     ->where('id', $request->get('id'))
            //     ->update(['registration_date' => $data['registration_date'],
            //             'unregistration_date' => $data['unregistration_date'], 
            //             'name' => $data['name'],
            //             'address' => $data['address'],
            //             'phone' => $data['phone'],
            //             'komisi' => $data['komisi'],
            //             'no_rekening' => $data['no_rekening'],
            //             'province' => $data['province'],
            //             'district' => $data['district'],
            //             'branch_id' => $data['branch_id']]);

            $cso = Cso::find($request->get('id'));

            if($request->get('komisi') == null || $request->get('komisi') == "")
            {
                $data['komisi'] = "0";
            }
            if($request->get('no_rekening') == null || $request->get('no_rekening') == "")
            {
                $data['no_rekening'] = "-";
            }
            $cso->fill($data)->save();

            return response()->json(['success'=>$data]);
        }
    }

    public function delete(Cso $cso)
    {
        $cso->active = false;
        $cso->save();
        return redirect()->route('cso');
    }
}
