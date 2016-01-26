<div class="pagination">

    <ul>
        {%  if(page.before != page.current) %}
            <li><a href="<?= Phalcon\Di\Service\UrlService::addParamToUrl('page', 1); ?>">{{trans._('first')}}</a></li>
            <li><a href="<?= Phalcon\Di\Service\UrlService::addParamToUrl('page', $page->before); ?>">{{trans._('previous')}}</a></li>
            <li>
                <a href="<?= Phalcon\Di\Service\UrlService::addParamToUrl('page', $page->before); ?>">{{ page.before }}</a>
            </li>
        {% endif %}
        <li class="active">
            <a href="#">{{ page.current }}</a>
        </li>
        {%  if(page.total_pages != page.current) %}
            <li>
                <a href="<?= Phalcon\Di\Service\UrlService::addParamToUrl('page', $page->next); ?>">{{ page.next }}</a>
            </li>
            <li><a href="<?= Phalcon\Di\Service\UrlService::addParamToUrl('page', $page->next); ?>">{{trans._('next')}}</a></li>

            <li><a href="<?= Phalcon\Di\Service\UrlService::addParamToUrl('page', $page->total_pages); ?>">{{trans._('last')}}</a></li>
        {% endif %}
    </ul>
</div>