@props(['id', 'name', 'value' => ''])

<input type="hidden" name="{{ $name }}" id="{{ $id }}_input" value="{{ $value }}">
<div id="{{ $id }}" style="height: 300px;" {{ $attributes->merge(['class' => 'border rounded']) }}></div>

@once
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
@endpush
@endonce

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quill{{ $id }} = new Quill('#{{ $id }}', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Set initial content
    const initialContent = document.getElementById('{{ $id }}_input').value;
    if (initialContent) {
        quill{{ $id }}.root.innerHTML = initialContent;
    }

    // Update hidden input on text change
    quill{{ $id }}.on('text-change', function() {
        document.getElementById('{{ $id }}_input').value = quill{{ $id }}.root.innerHTML;
    });

    // Update on form submit
    const form = document.getElementById('{{ $id }}').closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('{{ $id }}_input').value = quill{{ $id }}.root.innerHTML;
        });
    }
});
</script>
@endpush
