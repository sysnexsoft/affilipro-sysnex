<div class="row align-items-center pagination-wrapper mt-4">
    <div class="col-md-6 mb-2 mb-md-0">
        <div class="pagination-info">
            Showing
            @if ($paginator->firstItem())
                <span>{{ $paginator->firstItem() }}</span>
                -
                <span>{{ $paginator->lastItem() }}</span>
            @else
                <span>{{ $paginator->count() }}</span>
            @endif
            of <span>{{ $paginator->total() }}</span> results
        </div>
    </div>

    <div class="col-md-6">
        <nav class="d-flex justify-content-md-end justify-content-center">
            <ul class="custom-pagination">

                {{-- Previous --}}
                <li class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}">
                        <i class="ri-arrow-left-fill"></i>
                    </a>
                </li>

                @foreach ($elements as $element)

                    @if (is_string($element))
                        <li class="dots">{{ $element }}</li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    @endif

                @endforeach

                {{-- Next --}}
                <li class="{{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                    <a href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}">
                        <i class="ri-arrow-right-fill"></i>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</div>
<style>
    .pagination-wrapper{
        border-top:1px solid rgba(255,255,255,.06);
    }

    .pagination-info{
        color:#94a3b8;
        font-size:14px;
    }

    .pagination-info span{
        color:#fff;
        font-weight:600;
    }

    .custom-pagination{
        display:flex;
        align-items:center;
        gap:8px;
        list-style:none;
        padding:0;
        margin:0;
        flex-wrap:wrap;
    }

    .custom-pagination li a{
        width:40px;
        height:40px;
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius:12px;
        text-decoration:none;
        color:#cbd5e1;
        background:#162033;
        border:1px solid rgba(255,255,255,.08);
        transition:.3s;
    }

    .custom-pagination li a:hover{
        background:#6d5dfc;
        color:#fff;
        transform:translateY(-2px);
    }

    .custom-pagination li.active a{
        background:linear-gradient(135deg, #7c3aed, #6366f1);
        color:#fff;
        border:none;
        box-shadow:0 8px 25px rgba(124,58,237,.35);
    }

    .custom-pagination li.disabled a{
        opacity:.4;
        pointer-events:none;
    }

    .custom-pagination .dots{
        color:#64748b;
        padding:0 6px;
    }

    @media(max-width:768px){
        .pagination-info{
            text-align:center;
            margin-bottom:15px;
        }
        .custom-pagination{
            justify-content:center;
        }
    }
    .custom-pagination li a{
        backdrop-filter: blur(12px);
    }

    .custom-pagination li.active a{
        box-shadow: 0 0 20px rgba(99,102,241,.4),
        0 0 40px rgba(124,58,237,.2);
    }
</style>
