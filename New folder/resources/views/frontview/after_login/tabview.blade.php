 <!-- Tabs Nav -->
 <ul class="nav nav-tabs nav-pills mb-4 gap-2 justify-content-center" id="accountTabs" role="tablist">
     {{--  <li class="nav-item" role="presentation">
         <button class="nav-link active" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
             role="tab">
             <i class="bi bi-person"></i> Profile
         </button>
     </li>  --}}

     <li class="nav-item" role="presentation">
         <a class="nav-link @if (request()->routeIs('myorders')) {{ 'active' }} @endif" href="{{ route('myorders') }}">
             <i class="bi bi-bag-check"></i> Orders
         </a>
     </li>

     <li class="nav-item" role="presentation">
         <a class="nav-link @if (request()->routeIs('mywishlist.index')) {{ 'active' }} @endif"
             href="{{ route('mywishlist.index') }}">
             <i class="bi bi-heart"></i> Wishlist
         </a>
     </li>


 </ul>
