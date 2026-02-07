<x-app-layout>
    <x-slot name="header">
        <form action="" id="redirectForm">
            <select id="redirect-select" class="dropdown-arrow z-10 font-black text-xl bg-transparent border-0 text-gray-200 leading-tight black_contour"
            style="background-image: url('{{ asset('images/arrow_drop_down.png') }}');">
                <option value="" selected disabled>Volver</option>
                <option class="bg-black2 redirectOption" value="{{ route("dashboard.index") }}">Dashboard</option>
                <option class="bg-black2 redirectOption" value="{{ route("activity.index") }}">Actividades</option>
                <option class="bg-black2 redirectOption" value="{{ route("inventory.index") }}">Inventario</option>
                <option class="bg-black2 redirectOption" value="{{ route("person.index") }}">Personas</option>
                <option class="bg-black2 redirectOption" value="{{ route("loan.index") }}">Prestamos</option>
                <option class="bg-black2 redirectOption" value="{{ route("discipline.index") }}">Disciplinas</option>
                @can('is-admin')
                    <option class="bg-black2 redirectOption" value="{{ route("user.create") }}">Crear usuario</option>
                @endcan
                <option class="bg-black2 redirectOption" value="{{ route("session.destroy") }}">Cerrar sesión</option>
            </select>
        </form>

        <h3 class="absolute text-right sm:text-center w-full">
            <a href="{{ route("person.index") }}"
                class="text-white2
                text-2xl black_contour font-black">
                Registrando pago ({{  $discipline->name }})
            </a>
        </h3>
    </x-slot>

    <form action="{{ route('payment.store', $discipline) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="px-[10vw] py-[10vh] grid sm:grid-cols-2 gap-5">

                <input type="hidden" name="route" id="route" value="{{ route("student.getByDni", $discipline->id) }}">

                <div>
                    <label for="dni">Cédula</label>
                    <input type="text" name="dni" id="dni" class="block" placeholder="Escriba aquí..." value="{{ $student ? $student->person->dni : old('dni') }}">
                </div>

                <div>
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="block" placeholder="Introduzca la cédula..." readonly value="{{ $student ? $student->person->name : "" }}">
                </div>

                <div>
                    <label for="lastname">Apellido</label>
                    <input type="text" name="lastname" id="lastname" class="block" placeholder="Introduzca la cédula..." readonly value="{{ $student ? $student->person->lastname : "" }}">
                </div>

                <div>
                    <label for="loan_date">Fecha de pago</label>
                    <input type="date" id="date" name="date" class="block" value="{{ old('method', now()->format("Y-m-d")) }}">
                </div>

                <div>
                    <label for="loan_date">Método de pago</label>
                    <select name="method" id="method" class="block">
                        <option value="Pago móvil">Pago móvil</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Efectivo">Punto de venta</option>
                    </select>
                </div>
                <div>
                    <label for="loan_date">Siguiente fecha de pago</label>
                    <input type="date" name="next_payment" id="next_payment" class="block">
                </div>
                <div>
                    <label for="loan_date">Monto (bs)</label>
                    <input type="number" name="amount" id="amount" class="block" placeholder="Introduzca el monto...">
                </div>
                <div>
                    <label for="loan_date">Número de referencia (opcional)</label>
                    <input type="text" name="reference_number" id="reference_number" class="block" placeholder="Introduzca la referencia...">
                </div>
                <div>
                    <label for="loan_date">Recibo (opcional)</label>
                    <input type="file" name="" id="" class="block" placeholder="Introduzca el monto...">
                </div>

            </div>
            <div class="flex justify-center w-full items-end p-[5vh]">
                <button type="submit" class="rounded-3xl bg-yellow-900 text-md font-bold text-white2 black_contour py-3 px-10 hover:bg-yellow-800 transition">Registrar</button>
            </div>
    </form>

    <x-slot name="script">
        {{ asset("js/redirect.js") }}
    </x-slot>

    <x-slot name="script2">
        {{ asset("js/paymentCreation.js") }}
    </x-slot>
</x-app-layout>
