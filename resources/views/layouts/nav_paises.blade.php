<div class="page-nav">
    <div class="page-nav-fixed">
        <div class="limit">
            <nav class="page-nav-breadcrubms">
                <div class="page-nav-breadcrumbs-text">{{ trans('comun.estas_en') }}</div>
                <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li class="current-menu-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="#">
                            <span itemprop="name"> {{ $pais->pais }}</span><span class="fa fa-chevron-down"></span>
                        </a>
                        <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                            @foreach($paises as $p)
                                @if($pais->id!=$p->id)
                                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                        <a itemprop="item" href="{{route('game',$p->id_0)}}">
                                            <span itemprop="name"> {{ $p->pais }}</span>
                                        </a>
                                    </li>
                                @endif 
                            @endforeach
                        </ul>
                        <meta itemprop="position" content="1">
                    </li>
                </ul>
                <meta itemprop="position" content="2">
            </nav>
            <nav class="page-nav-subpages" data-icons="false,map-marker,calendar,star,image">
                <ul>
                    <li><a class="current" href="#"><span id="n_lugares_total" class="badge">{{ $items }}</span> {{ trans('comun.lugares_total') }}</a></li>
                </ul>
            </nav>
        </div><!--/limit-->
    </div><!--/page-nav-fixed-->
</div><!--/page-nav-->