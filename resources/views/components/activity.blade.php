<div data-status="{{ $status }}" class="activity-card outline-1 relative bg-white2 size-72 rounded-3xl py-3 px-4 flex flex-col items-center justify-between overflow-hidden">
    <header data-color="text-{{ $color2 }}" data-header-id="{{ $activityId }}" class="flex flex-col justify-between bg-gradient-to-r from-{{ $color }} to-{{ $color2 }} absolute top-0 h-[42%] w-full flex px-4 py-3">
        <h3 class="font-black black_contour_sm text-white2">{{ $title }}</h3>
    </header>
    <main class="flex w-full h-full items-end text-nowrap">
        <div class="full">
            <ul class="flex flex-col text-sm">
                <form action="{{ route('activity.update') }}" method="POST">
                    @csrf
                    <button class="self-end">
                        <input type="hidden" name="activityId" value="{{ $activityId }}">
                        <li class="cursor-pointer text-blue-400 border-b w-min border-blue-400">Editar</li>
                    </button>
                </form>
                {{ $slot }}
            </ul>
        </div>
    </main>

    <footer class="border-b-2 w-[70%]">
        <select
            data-activity-id="{{ $activityId }}"
            data-color="text-{{ $color }}"
            data-color2=""
            class='cursor-pointer appearance-none bg-transparent bg-no-repeat bg-right bg-size-[15px] border-0 border-b-1 outline-none text-{{ $color }} status-select-input font-black w-full text-center'
            name="status"
            id="status-select-{{ $activityId }}"
            style="background-image: url('{{ asset('images/edit_dark.png') }}');">

            <option value="Suspendida"  data-color2="text-red-300"    data-color="text-red-500"    class="text-red-500 status-select-option"    {{ $status == 'Suspendida' ? 'selected' : '' }}>Suspendida</option>
            <option value="Activa"      data-color2="text-purple-200" data-color="text-purple-400" class="text-purple-400 status-select-option" {{ $status == 'Activa' ? 'selected' : '' }}>Activa</option>
            <option value="En Espera"   data-color2="text-orange-200" data-color="text-orange-400" class="text-orange-400 status-select-option" {{ $status == 'En Espera' ? 'selected' : '' }}>En Espera</option>
            <option value="Completada"  data-color2="text-lime-200"   data-color="text-lime-400"   class="text-lime-400 status-select-option"   {{ $status == 'Completada' ? 'selected' : '' }}>Completada</option>
            <option value="Pospuesta"   data-color2="text-yellow-100" data-color="text-yellow-400" class="text-yellow-400 status-select-option" {{ $status == 'Pospuesta' ? 'selected' : '' }}>Pospuesta</option>
            <option value="En Progreso" data-color2="text-cyan-200"   data-color="text-cyan-400"   class="text-cyan-400 status-select-option"   {{ $status == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>

        </select>
    </footer>
</div>
