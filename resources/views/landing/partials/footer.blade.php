<footer class="bg-[#0d3c14] text-white">
    <!-- Footer Top -->
    <div class="border-b border-white/5">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Contact Info -->
                <div>
                    <h3 class="text-yellow-400 font-black text-lg uppercase mb-4">SARS</h3>
                    <p class="text-sm text-white/60 leading-relaxed">
                        The Regional Examination System<br>
                        Student Academic Results System<br><br>
                        <strong class="text-white/80">Phone:</strong> +255 763 074 657<br>
                        <strong class="text-white/80">Email:</strong> nnonimusa85@gmail.com<br>
                    </p>
                </div>

                <!-- Useful Links -->
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Useful Links</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="https://www.moe.go.tz/" target="_blank" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">MoEST</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="https://www.necta.go.tz/" target="_blank" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">NECTA</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="https://www.tanzania.go.tz/" target="_blank" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">National Website</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="{{ route('results.index') }}" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">Results Portal</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="{{ route('sitemap') }}" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">Sitemap</a></li>
                    </ul>
                </div>

                <!-- Quick Access -->
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Quick Access</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="{{ route('landing') }}#about" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">About Us</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="{{ route('landing') }}#services" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">Services</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="{{ route('landing') }}#faq" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">FAQ</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="{{ route('landing') }}#contacts" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">Contacts</a></li>
                        <li class="flex items-center gap-1"><i class="bi bi-chevron-right text-primary-500 text-xs"></i> <a href="/login" class="text-sm text-white/60 hover:text-yellow-400 transition-colors">Staff Login</a></li>
                    </ul>
                </div>

                <!-- Working Hours -->
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Working Hours</h4>
                    <p class="text-sm text-white/60 leading-relaxed">
                        Monday to Friday: 07:30 - 16:30<br>
                        Saturday to Sunday: Closed
                    </p>
                    <!-- Social Links -->
                    <div class="flex items-center gap-3 mt-4">
                        <a href="#" class="w-9 h-9 bg-white/10 hover:bg-yellow-400 rounded-lg flex items-center justify-center transition-all duration-300">
                            <i class="ri-facebook-fill text-white hover:text-[#0d3c14]"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 hover:bg-yellow-400 rounded-lg flex items-center justify-center transition-all duration-300">
                            <i class="ri-twitter-fill text-white hover:text-[#0d3c14]"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 hover:bg-yellow-400 rounded-lg flex items-center justify-center transition-all duration-300">
                            <i class="ri-instagram-line text-white hover:text-[#0d3c14]"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 hover:bg-yellow-400 rounded-lg flex items-center justify-center transition-all duration-300">
                            <i class="ri-youtube-fill text-white hover:text-[#0d3c14]"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="container mx-auto px-4 py-5">
        <div class="flex flex-col md:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('emblem.png') }}" alt="Emblem" class="h-8 w-auto object-contain opacity-60">
                <p class="text-xs text-white/40 uppercase tracking-widest font-bold">
                    &copy; {{ date('Y') }} SARS. All Rights Reserved.
                </p>
            </div>
            <p class="text-xs text-white/30">Student Academic Results System</p>
        </div>
    </div>
</footer>

<!-- Back to Top -->
<a href="#" onclick="scrollToTop(); return false;" class="fixed bottom-6 right-6 w-12 h-12 bg-primary-600 hover:bg-primary-700 text-white rounded-full flex items-center justify-center shadow-lg transition-all duration-300 z-50 opacity-0 pointer-events-none" id="backToTop">
    <i class="bi bi-arrow-up-short text-xl"></i>
</a>

<script>
window.addEventListener('scroll', function() {
    const btn = document.getElementById('backToTop');
    if (window.scrollY > 300) {
        btn.classList.remove('opacity-0', 'pointer-events-none');
        btn.classList.add('opacity-100');
    } else {
        btn.classList.add('opacity-0', 'pointer-events-none');
        btn.classList.remove('opacity-100');
    }
});

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>