<div class="navbar-area navbar-two">
    <div class="main-responsive-nav">
       <div class="container">
          <div class="main-responsive-menu">
            @php
                $langauge = App\Models\Language::where('status', true)->first();
                $logo = App\Models\Logo::where('language_id', $langauge->id)->where('status', true)->first();
                // dd($categor);
            @endphp
             <div class="logo">
                <a href="index.html">
                    <img class="responsive-nav-logo" src="{{ URL::to('/') }}/media/logos/{{ $logo->logo }}" alt="image">
                </a>
             </div>
          </div>
       </div>
    </div>
    <div class="main-navbar">
       <div class="container">
          <nav class="navbar navbar-expand-md navbar-light">
             <a class="navbar-brand" href="/">
             <img class="nav-logo" src="{{ URL::to('/') }}/media/logos/{{ $logo->logo }}" alt="image">
             </a>
             <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                <ul class="navbar-nav">
                   <li class="nav-item">
                      <a href="/" class="nav-link active">
                      Home
                      </a>
                   </li>
                   @php
                        $langauge = App\Models\Language::where('status', true)->first();
                        $categor = App\Models\Category::withCount('categories')->with('languages')->where('language_id', $langauge->id)->where('parent_id', null)->where('status', true)->take(8)->get();
                        // dd($categor);
                   @endphp

                   @foreach($categor as $key => $category)
                        {{-- @if($category->languages->status == true) --}}
                            {{-- @if($key > 0 && $key < 9) --}}

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    {{ $category->name }}

                                    @if($category->categories_count > 0)
                                    <i class='bx bx-chevron-down'></i>
                                    @endif
                                    </a>

                                    @if($category->categories_count > 0)
                                    <ul class="dropdown-menu">
                                        {{-- @dd($category->categories) --}}
                                        @foreach($category->categories as $sub_category)
                                        <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        {{ $sub_category->name }}
                                        </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif

                                </li>

                                {{-- @elseif($category->languages->id == 2)
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    {{ $category->name }}

                                    @if($category->categories_count > 0)
                                    <i class='bx bx-chevron-down'></i>
                                    @endif
                                    </a>

                                    @if($category->categories_count > 0)
                                    <ul class="dropdown-menu">
                                        @foreach($category->categories as $sub_category)
                                        <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        {{ $sub_category->name }}
                                        </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif

                                </li> --}}
                            {{-- @endif --}}
                        {{-- @endif --}}
                   @endforeach


                </ul>
                <div class="others-options d-flex align-items-center">
                   <div class="option-item">
                      <form class="search-box">
                         <input type="text" class="form-control" placeholder="Search for..">
                         <button type="submit"><i class='bx bx-search'></i></button>
                      </form>
                   </div>
                </div>
             </div>
          </nav>
       </div>
    </div>

    <div class="others-option-for-responsive">
       <div class="container">
          <div class="dot-menu">
             <div class="inner">
                <div class="circle circle-one"></div>
                <div class="circle circle-two"></div>
                <div class="circle circle-three"></div>
             </div>
          </div>
          <div class="container">
             <div class="option-inner">
                <div class="others-options d-flex align-items-center">
                   <div class="option-item">
                      <form class="search-box">
                         <input type="text" class="form-control" placeholder="Search for..">
                         <button type="submit"><i class='bx bx-search'></i></button>
                      </form>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
