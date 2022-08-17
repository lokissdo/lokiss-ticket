 
    <ul class="pagination align-self-center d-flex flex-wrap justify-content-center">
        @for ($i = 1; $i <= $total_page; ++$i)
            <li class="page-item">
                <a class="page-link hoverable" data-page="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor

    </ul>