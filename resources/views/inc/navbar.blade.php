<div class="header-bottom">
    <div class="container">
        <div class="logo">
            <a href="/"><img src="images/logo.png" class="img-responsive" alt="" /></a>
        </div>
        <div class="head-nav">
            <span class="menu"> </span>
            <ul>
                <li class="{{ Request::path() ==  '/' ? 'active' : ''  }}"><a href="/">Home</a></li>
                <li class="{{ Request::path() ==  'about' ? 'active' : ''  }}"><a href="/about">about</a></li>
                <li class="{{ Request::path() ==  'products' ? 'active' : ''  }}"><a href="/products">Products</a></li>
                <li class="{{ Request::path() ==  'news' ? 'active' : ''  }}"><a href="/news">News</a></li>
                <li class="{{ Request::path() ==  'contacts' ? 'active' : ''  }}"><a href="/contacts">Contacts</a></li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>