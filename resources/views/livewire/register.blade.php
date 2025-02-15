<div>
    @if($hasTitle)
        <header class="fixed w-full">
    @else
        <header class="w-full">
    @endif
        <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 py-2 mx-auto">
                <a href="#" class="flex items-center">
                    <img src={{ asset('images/logo.png') }} class="h-6 mr-3 sm:h-9 hidden sm:block lg:block" alt="Program Profesi Guru UIN SUSKA Riau" />
                    <div class="flex flex-col justify-between -space-y-[3px]">
                        <span class="text-xl font-semibold whitespace-nowrap dark:text-white">Lapor Diri PPG</span>
                        <span class="text-sm font-semibold whitespace-nowrap dark:text-white">Fakultas Tarbiyah dan Keguruan</span>
                        <span class="text-sm font-semibold whitespace-nowrap dark:text-white">Universitas Islam Negeri Sultan Syarif Kasim Riau</span>
                    </div>
                </a>
                <div class="flex items-center lg:order-2 lg:hidden lg:flex">
                    <!-- <a href="#" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log in</a> -->
                    {{-- <a href="https://themesberg.com/product/tailwind-css/landing-page" class="hidden text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800 lg:hidden">Download</a> --}}
                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only"></span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                @if($hasTitle)
                    <div class="items-center justify-between hidden w-full md:hidden lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <a href="#" class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white" aria-current="page">Beranda</a>
                            </li>
                            <li>
                                <a href="#syarat" class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-purple-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Syarat dan Ketentuan</a>
                            </li>
                            <li>
                                <a href="#formulir" class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-purple-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Pengisian Data</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </nav>
    </header>

    <!-- Start block -->
    <section class="bg-gray-50 pt-10">
        <div class="max-w-screen-2xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
            <div class="max-w-screen-2xl mx-auto">

                    @if (session()->has('message'))
                        <div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                            <div class="flex items-center">
                                <span class="sr-only">Info</span>
                                    <h3 class="text-lg font-medium">
                                        Penyimpanan Data Lapor Diri Berhasil
                                    </h3>
                                </div>
                            <div class="mt-2 mb-4 text-sm">
                                {{ session('message') }}
                            </div>
                            <div class="flex">
                                <button type="button" class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-green-600 dark:border-green-600 dark:text-green-400 dark:hover:text-white dark:focus:ring-green-800" data-dismiss-target="#alert-additional-content-3" aria-label="Close">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    @endif

                    <h1 class="flex justify-center mb-4 text-2xl font-extrabold leading-tight tracking-tight text-gray-900 pb-10">Formulir Pendaftaran</h1>
                    {{-- <a href="{{ route('beranda.index')}}" class="flex items-center justify-end w-full px-5 py-3 text-sm font-medium text-center text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <img class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-400" src="{{ asset('images/logo-uin-suska.png') }}"></img> Kembali Ke Beranda
                    </a> --}}
                    <div class="flex justify-end pb-10">
                        <a href="{{route('beranda.index')}}" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <img class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-400" src="{{ asset('images/logo-uin-suska.png') }}"></img>Kembali Ke Beranda</a>
                    </div>

                </div>
                <div class="-z-999">
                    {{ $this->form }}
                </div>
            </div>
        </div>
    </section>
</div>
