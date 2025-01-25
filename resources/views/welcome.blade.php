<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nomor WhatsApp</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="mt-6">
                    <div class="text-center">
                        <h1 class="text-2xl font-bold text-black dark:text-white">
                            Daftarkan nomor anda untuk pengingat absensi harian staff
                        </h1>
                    </div>
                    <div class="mt-8">
                        <form id="registerForm" class="max-w-md mx-auto">
                            <div class="mb-4">
                                <label for="nohp" class="block text-gray-700 text-sm font-bold mb-2">
                                    Nomor Handphone
                                </label>
                                <input type="text" id="nohp" name="nohp"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="62812345676" required>
                            </div>
                            <div class="flex items-center justify-between">
                                <button type="button" id="daftarBtn"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Daftar
                                </button>
                                <button type="button" id="hapusBtn"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Hentikan
                                </button>
                            </div>
                        </form>
                        <div id="statusMessage" class="mt-4 text-center"></div>
                    </div>
                </main>
            </div>

            <!-- FAQ Section -->
            <div class="w-full max-w-2xl px-6 lg:max-w-7xl mt-12">
                <h2 class="text-2xl font-bold text-black dark:text-white text-center">FAQ (Pertanyaan yang Sering
                    Diajukan)</h2>
                <div class="mt-8">
                    <!-- FAQ Item 1 -->
                    <div class="faq-item border-b pb-4">
                        <button class="faq-question text-lg font-semibold text-black dark:text-white w-full text-left">
                            Bagaimana cara mendaftar untuk pengingat absensi?
                        </button>
                        <div class="faq-answer text-gray-700 dark:text-gray-400 mt-2 hidden">
                            Masukkan nomor handphone Anda pada form yang tersedia, lalu klik "Daftar" dan lakukan verifikasi berupa otp yang kami kirimkan melalui nomor WhatsApp yang akan didaftarkan setelah berhasil. Kami
                            akan mengirimkan pengingat absensi setiap hari Sabtu-Kamis pagi dan sore.
                        </div>
                    </div>
                    <!-- FAQ Item 2 -->
                    <div class="faq-item border-b pb-4 mt-6">
                        <button class="faq-question text-lg font-semibold text-black dark:text-white w-full text-left">
                            Apakah layanan ini gratis?
                        </button>
                        <div class="faq-answer text-gray-700 dark:text-gray-400 mt-2 hidden">
                            Ya, layanan pengingat absensi ini gratis.
                        </div>
                    </div>
                    <!-- FAQ Item 3 -->
                    <div class="faq-item border-b pb-4 mt-6">
                        <button class="faq-question text-lg font-semibold text-black dark:text-white w-full text-left">
                            Bagaimana cara berhenti menerima pengingat?
                        </button>
                        <div class="faq-answer text-gray-700 dark:text-gray-400 mt-2 hidden">
                            Masukkan nomor handphone Anda pada form yang tersedia, lalu klik "Hentikan" dan lakukan verifikasi berupa otp yang kami kirimkan melalui nomor WhatsApp yang akan dihentikan.
                            Selamat anda telah berhasil menghentikan layanan.
                        </div>
                    </div>
                    <!-- FAQ Item 4 -->
                    <div class="faq-item border-b pb-4 mt-6">
                        <button class="faq-question text-lg font-semibold text-black dark:text-white w-full text-left">
                            Apa yang harus dilakukan jika saya mengalami masalah?
                        </button>
                        <div class="faq-answer text-gray-700 dark:text-gray-400 mt-2 hidden">
                            Jika Anda mengalami masalah, silakan mengirimkan email ke <a href="mailto:nashehannafii@gmail.com">nashehannafii@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach((question) => {
            question.addEventListener('click', () => {
                // Toggle class hidden pada jawaban
                const answer = question.nextElementSibling;
                answer.classList.toggle('hidden');

                // Ubah tanda + menjadi - jika konten terbuka, dan sebaliknya
                if (answer.classList.contains('hidden')) {
                    question.innerHTML = question.innerHTML.replace('−', '+');
                } else {
                    question.innerHTML = question.innerHTML.replace('+', '−');
                }
            });
        });

        // Event Listeners for Buttons
        document.getElementById('daftarBtn').addEventListener('click', function() {
            updateStatus("1", "0");
        });

        document.getElementById('hapusBtn').addEventListener('click', function() {
            updateStatus("0", "1");
        });

        function updateStatus(daftarValue, hapusValue) {
            const nohp = document.getElementById('nohp').value;
            const statusMessage = document.getElementById('statusMessage');

            fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nohp,
                        daftarBtn: daftarValue,
                        hapusBtn: hapusValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    statusMessage.textContent = data.message;

                    if (data.message.includes('OTP sent successfully')) {
                        showVerificationForm(nohp);
                    }
                })
                .catch(error => {
                    statusMessage.textContent = 'An error occurred. Please try again.';
                    console.error('Error:', error);
                });
        }

        function showVerificationForm(nohp) {
            const verificationForm = `
                <form id="verifyForm" class="max-w-md mx-auto mt-8">
                    <div class="mb-4">
                        <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">
                            OTP
                        </label>
                        <input type="text" id="otp" name="otp"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="123456" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Verifikasi OTP
                        </button>
                    </div>
                </form>
                <div id="verifyStatusMessage" class="mt-4 text-center"></div>
            `;

            document.getElementById('statusMessage').innerHTML = verificationForm;

            document.getElementById('verifyForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const otp = document.getElementById('otp').value;
                const verifyStatusMessage = document.getElementById('verifyStatusMessage');

                fetch('/verify', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nohp,
                            otp
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        verifyStatusMessage.textContent = data.message;
                    })
                    .catch(error => {
                        verifyStatusMessage.textContent = 'An error occurred. Please try again.';
                        console.error('Error:', error);
                    });
            });
        }
    </script>
</body>

</html>
