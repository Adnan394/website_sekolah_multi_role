<ul>
@foreach($children as $child)
    <li>
        <b>{{ $child->nama }}</b> - {{ $child->jabatan }}
        @if($child->children)
            @include('admin.struktur.tree',['children'=>$child->children])
        @endif
    </li>
@endforeach
</ul>