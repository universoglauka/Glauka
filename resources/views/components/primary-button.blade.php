<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary border border-transparent rounded-md p-1 ps-3 pe-3']) }}>
    {{ $slot }}
</button>
