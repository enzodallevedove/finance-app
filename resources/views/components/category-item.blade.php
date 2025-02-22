@props(['category'])

<li>
    <span class="category-name {{ $category['children'] ? 'caret' : '' }}">
        <a href="{{ route('categories.show', ['category' => $category['id']]) }}">
            {{ $category['name'] }}
        </a>
    </span>

    @if (!empty($category['children']))
        <ul>
            @foreach ($category['children'] as $child)
                <x-category-item :category="$child" />
            @endforeach
        </ul>
    @endif
</li>
