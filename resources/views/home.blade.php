@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Empleados</h3>
                        <p>Precio dolar hoy: ${{ $dollar }}</p>
                        <button class="btn btn-primary" id="CreateEmployee" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Crear usuario
                        </button>
                    </div>

                    <div class="card-body">
                        <table id="example" class="table table-striped text-center">
                            <thead class="text-center">
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>S. Dolares</th>
                                    <th>S. Pesos</th>
                                    <th>Correo</th>
                                    <th>Status</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->codigo }}</td>
                                        <td>{{ $employee->nombre }}</td>
                                        <td>${{ $employee->salarioDolares }}</td>
                                        <td>${{ $employee->salarioDolares * $dollar }}</td>
                                        <td>{{ $employee->correo }}</td>
                                        <td>
                                            @if ($employee->activo == 0)
                                                <p style="color: red;">Inactivo</p>
                                            @else
                                                <p style="color: green;">Activo</p>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary"
                                                    onclick="setUpdate(
                                                        '{{ $employee->id }}',
                                                        '{{ $employee->codigo }}',
                                                        '{{ $employee->nombre }}',
                                                        '{{ $employee->salarioDolares }}',
                                                        '{{ $employee->salarioPesos }}',
                                                        '{{ $employee->direccion }}',
                                                        '{{ $employee->estado }}',
                                                        '{{ $employee->ciudad }}',
                                                        '{{ $employee->celular }}',
                                                        '{{ $employee->correo }}',
                                                        '{{ $employee->activo }}'
                                                    )"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalUpdate">
                                                    Editar
                                                </button>
                                                @if ($employee->activo == 0)
                                                    <form
                                                        action="{{ route('employees.activate', ['id' => $employee->id]) }}"
                                                        method="post"
                                                        onsubmit="return confirm('¿Estás seguro de activar este empleado?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Activar</button>
                                                    </form>
                                                    <form action="{{ route('employees.delete', ['id' => $employee->id]) }}"
                                                        method="post"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar este empleado?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-warning">Eliminar</button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('employees.deactivate', ['id' => $employee->id]) }}"
                                                        method="post"
                                                        onsubmit="return confirm('¿Estás seguro de desactivar este empleado?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Desactivar</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de crear --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('save') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="id" name="id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="codigo" name="codigo">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        onkeypress="return validarInput(event)" required>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6 mt-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dolar $</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Salario en Dólares"
                                        name="salarioDolares" id="salarioDolares" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Pesos $</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Salario en Pesos"
                                        name="salarioPesos" id="salarioPesos" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="direccion">Dirección:</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado:</label>
                                    <input type="text" class="form-control" id="estado" name="estado" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad:</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="celular">Celular:</label>
                                <input type="text" required class="form-control" id="celular" name="celular"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="correo">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="activo">Activo:</label>
                                    <select class="form-control" id="activo" name="activo" required>
                                        <option value="1" selected>Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  Modal de actualizar --}}
    <div class="modal fade" id="exampleModalUpdate" tabindex="2" aria-labelledby="exampleModalLabelUpdate"
        aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelUpdate"></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="Uid" name="id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="Ucodigo" name="codigo">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="Unombre" name="nombre"
                                        onkeypress="return validarInput(event)" required>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6 mt-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dolar $</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Salario en Dólares"
                                        name="salarioDolares" id="UsalarioDolares" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Pesos $</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Salario en Pesos"
                                        name="salarioPesos" id="UsalarioPesos" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="direccion">Dirección:</label>
                                    <input type="text" class="form-control" id="Udireccion" name="direccion"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado:</label>
                                    <input type="text" class="form-control" id="Uestado" name="estado" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad:</label>
                                    <input type="text" class="form-control" id="Uciudad" name="ciudad" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="celular">Celular:</label>
                                <input type="text" required class="form-control" id="Ucelular" name="celular"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="correo">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="Ucorreo" name="correo" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="activo">Activo:</label>
                                    <select class="form-control" id="Uactivo" name="activo" required>
                                        <option value="1" selected>Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <canvas id="dolares"></canvas>
                                <canvas id="pesos"></canvas>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <!-- Script para inicializar DataTables y limpiar el formulario al hacer clic en "Crear usuario" -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            // Limpiar el formulario al hacer clic en el botón "Crear usuario"
            $("#CreateEmployee").click(function() {
                $('#exampleModalLabel').text('Crear usuario');
                $("#myForm :input").val('');
                $('#myForm').attr('action', "{{ route('save') }}");
                $('#myForm').attr('method', 'POST');
            });
        });

        $("#salarioDolares").on('input', function() {
            // Obtener el valor del salario en dólares
            var salarioDolares = parseFloat($(this).val());

            // Verificar si el salario en dólares es un número válido
            if (!isNaN(salarioDolares)) {
                // Obtener el valor de la tasa de cambio
                var dollar = parseFloat("{{ $dollar }}");

                // Calcular el salario en pesos multiplicando el salario en dólares por la tasa de cambio
                var salarioPesos = salarioDolares * dollar;

                salarioPesos = salarioPesos.toFixed(2);

                // Mostrar el salario en pesos en el campo respectivo
                $("#salarioPesos").val(salarioPesos);
            }
        });

        $("#UsalarioDolares").on('input', function() {
            // Obtener el valor del salario en dólares
            var salarioDolares = parseFloat($(this).val());

            // Verificar si el salario en dólares es un número válido
            if (!isNaN(salarioDolares)) {
                // Obtener el valor de la tasa de cambio
                var dollar = parseFloat("{{ $dollar }}");

                // Calcular el salario en pesos multiplicando el salario en dólares por la tasa de cambio
                var salarioPesos = salarioDolares * dollar;

                salarioPesos = salarioPesos.toFixed(2);

                // Mostrar el salario en pesos en el campo respectivo
                $("#UsalarioPesos").val(salarioPesos);
            }
        });

        function setUpdate(id, codigo, nombre, salarioDolares, salarioPesos, direccion,
            estado, ciudad, celular, correo, activo) {
            $('#exampleModalLabelUpdate').text('Usuario: ' + nombre + " # " + codigo);
            $('#Uid').val(id);
            $('#Ucodigo').val(codigo);
            $('#Unombre').val(nombre);
            $('#UsalarioDolares').val(salarioDolares);
            $('#UsalarioPesos').val(salarioPesos);
            $('#Udireccion').val(direccion);
            $('#Uestado').val(estado);
            $('#Uciudad').val(ciudad);
            $('#Ucelular').val(celular);
            $('#Ucorreo').val(correo);
            $('#Uactivo').val(activo);

            const dolares = document.getElementById('dolares');
            const pesos = document.getElementById('pesos');

            const meses = {!! json_encode($meses) !!};

            // Calculating salary for each month
            const salarioDolaresIncrementado = [];
            const salarioPesosIncrementado = [];

            let salarioDolaresActual = salarioDolares;
            let salarioPesosActual = salarioPesos;

            for (let i = 0; i < 6; i++) {
                salarioDolaresActual *= 1.02; // Incremento del 2%
                salarioPesosActual *= 1.02; // Incremento del 2%
                salarioDolaresIncrementado.push(salarioDolaresActual);
                salarioPesosIncrementado.push(salarioPesosActual);
            }

            new Chart(dolares, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Proyeccion Salarial a 6 Meses en Dolares',
                        data: salarioDolaresIncrementado,
                        borderColor: '#36A2EB',
                        backgroundColor: '#9BD0F5',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(pesos, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Proyeccion Salarial a 6 Meses en Pesos',
                        data: salarioPesosIncrementado,
                        borderColor: '#FF6384',
                        backgroundColor: '#FFB1C1',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }


        function validarInput() {
            var input = document.getElementById('nombre').value;
            var regex = /^[a-zA-Z\s]*$/; // Expresión regular que permite solo letras sin acentos y espacios

            if (!regex.test(input)) {
                alert('Por favor, ingresa solo letras sin acentos ni caracteres especiales.');
                return false;
            }

            return true;
        }

        function validarInput(event) {
            var charCode = event.keyCode || event.which;
            var charStr = String.fromCharCode(charCode);

            // Rechazar la entrada si el carácter es una "ñ" o una letra acentuada
            if (charStr.match(/[ñáéíóúÁÉÍÓÚ]/)) {
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
@endsection
