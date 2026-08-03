<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger btn-lg rounded-pill px-5 w-100 mb-2']) }}>
    {{ $slot }}
</button>
