<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item active "><a href=""><i class="la la-mouse-pointer"></i><span
                        class="menu-title" data-i18n="nav.add_on_drag_drop.main">الرئيسية </span></a>
            </li>

            <li class="nav-item  open ">
                <a href=""><i class="la la-home"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">لغات الموقع </span>
                    <span
                        class="badge badge badge-info badge-pill float-right mr-2"></span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->segment(3) == 'users' ? 'active' : '' }}"><a class="menu-item" href="#"
                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                    </li>
                    <li><a class="menu-item" href="" data-i18n="nav.dash.crypto">أضافة
                            لغة جديده </a>
                    </li>
                </ul>
            </li>


            @can('categories')
            <li class="nav-item"><a href=""><i class="la la-home"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.categories')}}</span>
                    <span
                        class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Category::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.categories' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.categories.index')}}"
                                          data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}}</a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.categories.create')}}" data-i18n="nav.dash.crypto">
                            {{__('admin/sidebar.add new cat')}} </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('brands')
            <li class="nav-item"><a href=""><i class="la la-globe"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.brands')}}</span>
                    <span
                        class="badge badge badge-success badge-pill float-right mr-2">{{App\Models\Brand::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.brands' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.brands.index')}}"
                                          data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}}</a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.brands.create')}}" data-i18n="nav.dash.crypto">
                            {{__('admin/sidebar.add new brand')}}</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('tags')
            <li class="nav-item"><a href=""><i class="la la-tags"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.tags')}}</span>
                    <span
                        class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Tag::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.tags' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.tags.index')}}"
                                          data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}}</a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.tags.create')}}" data-i18n="nav.dash.crypto">
                            {{__('admin/sidebar.add new tag')}}</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('products')
            <li class="nav-item"><a href=""><i class="la la-cart-arrow-down"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.products')}}</span>
                    <span
                        class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Product::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.products' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.products')}}"
                                          data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}} </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.products.general.create')}}" data-i18n="nav.dash.crypto">{{__('admin/sidebar.add new product')}}
                             </a>
                    </li>
                </ul>
            </li>
            @endcan


            @can('attributes')
            <li class="nav-item"><a href=""><i class="la la-cart-arrow-down"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.attributes')}}</span>
                    <span
                        class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Attribute::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.attributes' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.attributes.index')}}"
                                                                                             data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}} </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.attributes.create')}}" data-i18n="nav.dash.crypto">{{__('admin/sidebar.add new attribute')}}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan


            @can('options')
            <li class="nav-item"><a href=""><i class="la la-cart-arrow-down"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.options')}}</span>
                    <span
                        class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Option::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.options' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.options.index')}}"
                                                                                               data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}} </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.options.create')}}" data-i18n="nav.dash.crypto">{{__('admin/sidebar.add new option')}}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan



            @can('roles')
            <li class="nav-item"><a href=""><i class="la la-cart-arrow-down"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.roles')}}</span>
                    <span
                        class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Role::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.roles' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.roles.index')}}"
                                                                                            data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}} </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.roles.create')}}" data-i18n="nav.dash.crypto">{{__('admin/sidebar.add new role')}}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan


            @can('admins')
            <li class="nav-item"><a href=""><i class="la la-cart-arrow-down"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">{{__('admin/sidebar.admins')}}</span>
                    <span
                        class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Admin::count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{'admin.admins' == request()->path() ? 'active' : ''}}"><a class="menu-item" href="{{route('admin.admins.index')}}"
                                                                                          data-i18n="nav.dash.ecommerce">{{__('admin/sidebar.show all')}} </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.admins.create')}}" data-i18n="nav.dash.crypto">{{__('admin/sidebar.add new admin')}}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan



            @can('settings')
            <li class=" nav-item"><a href="#"><span class="menu-title"
                                                      data-i18n="nav.templates.main"><i class="la la-cogs"></i>{{__('admin/sidebar.settings')}}</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="#" data-i18n="nav.templates.vert.main"><i class="la la-shopping-cart"></i>
                            {{__('admin/sidebar.shipping methods')}}</a>
                        <ul class="menu-content">

                            <li><a class="menu-item" href="{{route('admin.edit.shipping.method', 'free')}}"
                                   data-i18n="nav.templates.vert.classic_menu">{{__('admin/sidebar.free shipping')}}</a>
                            </li>

                            <li><a class="menu-item" href="{{route('admin.edit.shipping.method', 'inner')}}">{{__('admin/sidebar.inner shipping')}}</a>
                            </li>

                            <li><a class="menu-item" href="{{route('admin.edit.shipping.method', 'outer')}}"
                                   data-i18n="nav.templates.vert.compact_menu">{{__('admin/sidebar.outer shipping')}}</a>
                            </li>
                        </ul>
                    </li>

                      <li><a class="menu-item" href="#" data-i18n="nav.templates.vert.main"><i class="la la-shopping-cart"></i>
                        {{__('admin/sidebar.main slider')}}</a>
                          <ul class="menu-content">
                              <li><a class="menu-item" href="{{route('admin.sliders.create')}}"
                                   data-i18n="nav.templates.vert.classic_menu">{{__('admin/sidebar.slider images')}}</a>
                              </li>
                          </ul>
                     </li>
                </ul>
            </li>
            @endcan



        </ul>
    </div>
</div>
