<template>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
            <h2 class="text-4xl font-bold dark:text-white text-center mb-8">Cara Kerja</h2>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                Pelajari bagaimana simpeg bekerja dengan 3 langkah mudah.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="py-8 px-4 lg:py-16 lg:px-12">
                <div class="mb-4 flex items-center justify-center w-12 h-12 text-xl font-bold bg-purple-100 text-purple-800 dark:bg-purple-200 dark:text-purple-900 border border-purple-300 rounded-full shadow-xl border-opacity-40">
                    1
                </div>

                <h3 class="text-3xl font-bold dark:text-white mb-8">Tentukan tempat presensi</h3>

                <p class="mb-8 text-gray-500 dark:text-gray-400 text-lg font-normal lg:text-xl">
                    Masukkan nama tempat, latitude, dan longitude. Apabila Anda tidak tahu latitude dan longitude dari tempat presensi, tekan tombol "Temukan koordinat", Simpeg akan secara otomatis mengisikan latitude dan longitude berdasarkan lokasi Anda.
                </p>
            </div>
            <div>
                <img src="/howItWork-setUplocation.webp" alt="How it work | Set up location"
                     class="w-full h-auto lg:rounded-l-xl lg:border-l">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="py-8 px-4 lg:py-16 lg:px-12">
                <div class="mb-4 flex items-center justify-center w-12 h-12 text-xl font-bold bg-purple-100 text-purple-800 dark:bg-purple-200 dark:text-purple-900 border border-purple-300 rounded-full shadow-xl border-opacity-40">
                    2
                </div>

                <h3 class="text-3xl font-bold dark:text-white mb-8">Tentukan radius presensi dan jam kerja</h3>

                <p class="mb-8 text-gray-500 dark:text-gray-400 text-lg font-normal lg:text-xl">
                    Pilih lokasi yang Anda inginkan, berapa radius presensi yang diperbolehkan, dan jam kerja.
                    Simpeg hanya akan menyimpan data presensi apabila Pegawai anda berada di dalam radius presensi dan dalam jam kerja.
                </p>
            </div>
            <div class="lg:order-first">
                <img src="/howItWork-setUpDistanceAndWorkHour.webp" alt="How it work | Set up Distance and work hour"
                     class="w-full h-auto lg:rounded-r-xl lg:border-r">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="py-8 px-4 lg:py-16 lg:px-12">
                <div class="mb-4 flex items-center justify-center w-12 h-12 text-xl font-bold bg-purple-100 text-purple-800 dark:bg-purple-200 dark:text-purple-900 border border-purple-300 rounded-full shadow-xl border-opacity-40">
                    3
                </div>

                <h3 class="text-3xl font-bold dark:text-white mb-8">Selesai</h3>

                <p class="mb-8 text-gray-500 dark:text-gray-400 text-lg font-normal lg:text-xl">
                    Coba presensi di aplikasi Simpeg dengan menekan tombol +.
                    Apabila lokasi dan jam kerja sesuai, Data presensi akan disimpan.
                </p>
            </div>
            <div>
                <img src="/howItWork-test.webp" alt="How it work | Set up location"
                     class="w-full h-auto lg:rounded-l-xl lg:border-l">
            </div>
        </div>
    </section>
</template>
