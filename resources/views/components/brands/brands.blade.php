@props(['brands'])

<div class="flex flex-col items-center w-full space-y-6">
    <h2 class="text-4xl font-bold text-gray-800">Some of our brands</h2>
    <section class="w-full px-4" aria-label="Brand showcase">
        <ul class="grid grid-cols-2 md:grid-cols-6 lg:grid-cols-5 gap-8 justify-items-center list-none" role="list">
            <li class="flex justify-center items-center w-full md:col-span-2 lg:col-span-1" role="listitem">
                <img src="{{ asset('images/brands/cartier_logo.svg') }}" 
                     alt="Cartier - Luxury Jewelry"
                     class="w-full h-[120px] object-contain" 
                     loading="lazy">
            </li>
            <li class="flex justify-center items-center w-full md:col-span-2 lg:col-span-1" role="listitem">
                <img src="{{ asset('images/brands/porsche_logo.svg') }}" 
                     alt="Porsche - Luxury Cars" 
                     class="w-full h-20 object-contain"
                     loading="lazy">
            </li>
            <li class="flex justify-center items-center w-full md:col-span-2 lg:col-span-1" role="listitem">
                <img src="{{ asset('images/brands/rolex_logo.svg') }}" 
                     alt="Rolex - Luxury Watches" 
                     class="w-full h-20 object-contain"
                     loading="lazy">
            </li>
            <li class="flex justify-center items-center w-full md:col-start-2 md:col-span-2 lg:col-span-1 lg:col-start-auto" role="listitem">
                <img src="{{ asset('images/brands/gucci_logo.svg') }}" 
                     alt="Gucci - Luxury Fashion" 
                     class="w-full h-20 object-contain"
                     loading="lazy">
            </li>
            <li class="hidden md:flex justify-center items-center w-full md:col-span-2 lg:col-span-1" role="listitem">
                <img src="{{ asset('images/brands/glenfiddich_logo.svg') }}" 
                     alt="Glenfiddich - Luxury Whisky"
                     class="w-full h-[120px] object-contain" 
                     loading="lazy">
            </li>
        </ul>
    </section>
</div>