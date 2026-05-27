<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="background: linear-gradient(to right, #24a4ee, #6ce2e2, #94cbe0, #b1ccd3);
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
