<div>
    <header class="fixed w-full">
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
    <section class="bg-white dark:bg-gray-900 hero pt-20">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">Berkarya <span class="text-yellow-400">Gemilang</span> <br>Berprestasi <span class="text-green-400">Terbilang</span></h1>
                <div class="flex flex-col mb-4">
                    <h2 class="max-w-2xl text-lg font-bold md:text-xl lg:text-2xl dark:text-gray-400">Fakultas Tarbiyah dan Keguruan</h2>
                    <h2 class="max-w-2xl text-lg font-bold md:text-xl lg:text-2xl dark:text-gray-400">Universitas Islam Negeri Sultan Syarif Kasim Riau.</>
                </div>
                <div class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <a href="https://uin-suska.ac.id" target="_blank" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <img class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-400" src="{{ asset('images/logo-uin-suska.png') }}"></img> Website Resmi Universitas
                    </a> 
                    <a href="https://ftk.uin-suska.ac.id" target="_blank" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <img class="w-6 h-6 mr-2 text-gray-500 dark:text-gray-400" src="{{ asset('images/logo-uin-suska.png') }}"></img> Website Resmi Fakultas
                    </a>
                </div>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{ asset('images/rektor.png') }}" class="h-75" alt="hero image">
            </div>                
        </div>
    </section>
    <!-- End block -->
    <section class="bg-gray-50 dark:bg-gray-800">
        <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
            <figure class="max-w-screen-md mx-auto">
                <svg class="h-12 mx-auto mb-3 text-gray-400 dark:text-gray-600" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z" fill="currentColor"/>
                </svg> 
                <blockquote>
                    <p class="text-sm font-medium text-gray-900 md:text-xl lg:text-xl">"Puji syukur kepada Allah SWT karena Rahmat dan Karunia-Nya Universitas Islam Negeri Sultan Syarif Kasim Riau Hadir dan Besar hingga saat sekarang ini. Dengan semangat pengembangan kami selalu memberikan Kontribusi Terbaik kami untuk membangun Universitas Islam Negeri Sultan Syarif Kasim Riau menuju kepada Universitas yang Termuka ditingkat Dunia, dan selalu berkomitmen mengintegrasikan Nilai-Nilai Akhlak Keislaman dengan Ilmu Pengetahuan dan Teknologi. Semoga Universitas Islam Negeri Sultan Syarif Kasim Riau selalu memberikan Karya-Karya Gemilang untuk Bangsa dan negara serta Mengukir Prestasi-Prestasi Terbilang untuk tingkat dunia."</p>
                </blockquote>
                <figcaption class="flex items-center justify-center mt-6 space-x-3">
                    <div class="flex items-center divide-x-2 divide-gray-500 dark:divide-gray-700">
                        <div class="pr-3 font-medium text-gray-900 dark:text-white">Prof. Dr. Hairunas, M.Ag</div>
                        <div class="pl-3 text-sm font-light text-gray-500 dark:text-gray-400">Rektor Universitas Islam Negeri Sultan Syarif Kasim Riau</div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </section>
    <!-- Start block -->
    <section class="bg-white" id="syarat">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <img class="hidden w-full mb-4 rounded-lg lg:mb-0 lg:flex" src="{{ asset('images/mhs-uin.jpg') }}" alt="Lapor Diri PPG">
                <div class="text-gray-500 sm:text-lg dark:text-gray-400">
                    <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Lapor Diri Universitas Islam Negeri Sultan Syarif Kasim Riau</h2>
                    <p class="mb-8 font-light lg:text-xl">Lapor Diri diwajibkan bagi guru yang dinyatakan lulus seleksi administrasi. Lapor Diri dilakukan melalui platform Lapor Diri Universitas Islam Negeri Sultan Syarif Kasim Riau. <span class="font-bold text-black">Adapun Berkas Yang Perlu Dipersiapkan Adalah :</span></p>
                    <!-- List -->
                    <ul role="list" class="pt-8 space-y-5 border-t border-gray-200 my-7 dark:border-gray-700">
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Kartu Tanda Penduduk</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Foto terbaru dengan ketentuan latar warna merah, bagi laki-laki menggunakan jas dan dasi warna hitam, bagi perempuan menyesuaikan</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Ijazah yang digunakan untuk linieritas PPG beserta transkip nilai</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">SK mengajar sebagai guru maksimal 6 tahun terakhir</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Dokumen Perangkat Pembelajaran yang pernah dibuat terdiri dari: RPP/Modul Ajar, Materi Ajar, LKPD, Alat Peraga/Media Pembelajaran, dan Instrumen Penilaian maksimal 12 semester</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Dokumen Pengembangan Kompetensi Profesional yang pernah diikuti, terdiri dari sertifikat/piagam/Surat Keterangan mengikuti kegiatan ilmiah dari KKG/MGMP/Forum Sejenis maksimal 12 semester</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Dokumen Pengelolaan Administrasi Pembelajaran dibuktikan dengan Surat Keterangan dari Kepala Sekolah/Madrasah tentang keaktifan guru di bidang manajerial</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Dokumen inovasi pembelajaran atau karya lain 6 tahun terakhir</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End block -->
    <!-- Start block -->
    <section class="bg-gray-50 dark:bg-gray-800" id="formulir">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
            <div class="max-w-screen-sm mx-auto text-center">
                <h2 class="mb-2 text-3xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white">Formulir Lapor Diri Program Profesi Guru</h2>
                <p class="mb-6 font-semibold text-gray-500 dark:text-gray-400 sm:text-sm md:text-sm lg:text-sm">Apabila Seluruh Data dan Berkas Sudah Ada, Silahkan Klik Tombol Di Bawah Untuk Mengisi Data</p>
                <a href="{{ route('pendaftaran.index') }}" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">Pengisian Data</a>
            </div>
        </div>
    </section>
    <!-- End block -->
</div>
