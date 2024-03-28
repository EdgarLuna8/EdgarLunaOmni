<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        date_default_timezone_set('America/Mexico_City');
        $employees = Employee::all();
        $url = 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/' . date('Y-m-d') . '/' . date('Y-m-d');
        $token = '111c135933dbd27d85a50c00849f0dd5a154c2a4d873caca7ec55c485cf64471';

        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Bmx-Token' => $token,
        ])->get($url);

        $data = $response->json();

        if (isset($data['bmx']['series'][0]['datos'][0]['dato'])) {
            $dollar = number_format((float)$data['bmx']['series'][0]['datos'][0]['dato'], 2);
        } else {
            $dollar = "N/A";
        }

        $meses = array();
        $mes_actual = date('n');
        $nombres_meses = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        );

        for ($i = 0; $i < 5; $i++) {
            $mes = ($mes_actual + $i) % 12;
            if ($mes == 0) $mes = 12; // Ajuste para diciembre
            $meses[] = $nombres_meses[$mes];
        }

        return view('home', [
            'employees' => $employees,
            'dollar' => $dollar,
            'meses' => $meses
        ]);
    }



    public function create(Request $request)
    {
        // return $request;
        $input = $request->all();

        $caracteres = '0123456789';
        $codigo = '';
        for ($i = 0; $i < 8; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'salarioDolares' => 'required|numeric',
            'salarioPesos' => 'required|numeric',
            'direccion' => 'required|string',
            'estado' => 'required|string',
            'ciudad' => 'required|string',
            'celular' => 'required|string',
            'correo' => 'required|email',
            'activo' => 'required|boolean',
        ]);

        try {
            $employee = Employee::create([
                'codigo' => $codigo,
                'nombre' => $input['nombre'],
                'salarioDolares' => $input['salarioDolares'],
                'salarioPesos' => $input['salarioPesos'],
                'direccion' => $input['direccion'],
                'estado' => $input['estado'],
                'ciudad' => $input['ciudad'],
                'celular' => $input['celular'],
                'correo' => $input['correo'],
                'activo' => $input['activo'],
            ]);
            return redirect()->back()->with('success', 'Empleado ' . $input['nombre'] . ' creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear empleado: ' . $e->getMessage());
        }
    }


    public function update(Request $request)
    {
        $input = $request->all();

        $employee = Employee::findOrFail($input['id']);

        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'salarioDolares' => 'required|numeric',
            'salarioPesos' => 'required|numeric',
            'direccion' => 'required|string',
            'estado' => 'required|string',
            'ciudad' => 'required|string',
            'celular' => 'required|string',
            'correo' => 'required|email',
            'activo' => 'required|boolean',
        ]);
        try {
            $employee->update($validatedData);
            return redirect()->back()->with('success', 'Empleado ' . $input['nombre'] . ' actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear empleado: ' . $e->getMessage());
        }
    }

    public function activate($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->activo = true;
        $employee->save();

        return redirect()->back()->with('success', 'Empleado activado correctamente.');
    }

    public function deactivate($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->activo = false;
        $employee->save();

        return redirect()->back()->with('success', 'Empleado desactivado correctamente.');
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->back()->with('success', 'Empleado eliminado correctamente.');
    }
}
