
<div class="ml-10">
    {{-- <div class="ml-10">
        <div class="ml-2 capitalize text-blue-95 font-bold">
            {{ $pais }}
        </div>
        <div class="mb-4 rounded-sm" wire:ignore>
            <select wire:model="pais" id="select2" class="select2" style="width: 100%">
                <option value="PE">PERU</option>
                <option value="CH">CHILE</option>
                <option value="AR">ARGENTINA</option>
            </select>
        </div>
        <div>
            <input class="rounded-sm" wire:model="ciudad" type="text" placeholder="Buscar...">
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            $('.select2').select2({
                width: '100%', // Ajusta el ancho del select2
                placeholder: 'Buscar...', // Texto del placeholder
                allowClear: true // Permite borrar la selección
            });
            $('.select2').on('change', function(){
                @this.set('pais', this.value);
            });
        });
    </script>
    @endpush --}}


<div class="mt-9">

    <div wire:ignore>
        <select wire:model="companies"  id="testdropdown" class="w-full mr-6 form-control rounded-sm">
            <option value="">Selecciona un Directorio</option>
            <option value="Apple">Apple</option>
            <option value="Samsung">Samsung</option>
            <option value="HTC">HTC</option>
            <option value="One Plus">One Plus</option>
            <option value="Nokia">Nokia</option>
        </select>
    </div>

    <button wire:click="save">Save</button>

    @script()
        <script>
            $(document).ready(function() {
                $('#testdropdown').select2();
                $('#testdropdown').on('change', function() {
                    let data = $(this).val();
                    console.log(data);
                    // $wire.set('companies', data, false);
                    // $wire.companies = data;
                    @this.companies = data;

                });
            });
        </script>
    @endscript
</div>
</div>
