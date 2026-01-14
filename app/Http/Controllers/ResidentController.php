<?php

namespace App\Http\Controllers;
use App\Models\Resident;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index(){
        $residents = Resident::with('user')->paginate(5);


        return view('pages.resident.index', [
            'residents' => $residents,
        ]);
    }

    // create
    public function create(){
        return view('pages.resident.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nik' => ['required', 'min:16', 'max:16'],
            'nama' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'tanggal_lahir' => ['required', 'string'],
            'tempat_lahir' => ['required', 'max:100'],
            'alamat' => ['required', 'max:700'],
            'agama' => ['nullable', 'max:50'],
            'status_perkawinan' => ['required', Rule::in(['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati'])],
            'pekerjaan' => ['nullable', 'max:100'],
            'no_hp' => ['nullable', 'max:15'],
            'status' => ['required', Rule::in(['aktif', 'pindah', 'meninggal'])],
        ]);

        Resident::create($validatedData);

        return redirect('/resident')->with('success', 'Berhasil menambahkan data');
    }

    //update
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'nik' => ['required', 'min:16', 'max:16'],
            'nama' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'tanggal_lahir' => ['required', 'string'],
            'tempat_lahir' => ['required', 'max:100'],
            'alamat' => ['required', 'max:700'],
            'agama' => ['nullable', 'max:50'],
            'status_perkawinan' => ['required', Rule::in(['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati'])],
            'pekerjaan' => ['nullable', 'max:100'],
            'no_hp' => ['nullable', 'max:15'],
            'status' => ['required', Rule::in(['aktif', 'pindah', 'meninggal'])],
        ]);

        Resident::findOrFail($id)->update($validatedData);

        return redirect('/resident')->with('success', 'Berhasil mengubah data');
    }

    // edit
    public function edit($id){

        $resident = Resident::findOrFail($id);

        return view('pages.resident.edit', [
            'resident' => $resident,
        ]);
    }

    // delete
    public function destroy($id){
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return redirect('/resident')->with('success', 'Data penduduk berhasil dihapus');
    }
}
