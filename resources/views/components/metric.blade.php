@props(['label', 'value', 'note', 'tone' => 'teal'])

<article class="metric-card">
    <span class="metric-icon {{ $tone }}">▣</span>
    <p>{{ $label }}</p>
    <strong>{{ $value }}</strong>
    <small>{{ $note }}</small>
</article>
