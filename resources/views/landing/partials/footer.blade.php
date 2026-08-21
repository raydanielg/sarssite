<footer class="bg-[#0d3c14] text-white py-8 border-t border-white/5">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('emblem.png') }}" alt="Emblem" class="h-10 w-auto object-contain opacity-80">
                <div>
                    <p class="text-sm font-black text-yellow-400 uppercase tracking-tight">SARS</p>
                    <p class="text-[10px] text-white/50 uppercase tracking-widest">Student Academic Results System</p>
                </div>
            </div>
            <p class="text-xs font-bold text-white/40 uppercase tracking-widest text-center">
                &copy; {{ date('Y') }} SARS. All Rights Reserved.
            </p>
            <div class="flex items-center gap-3 text-white/40">
                <a href="#" class="hover:text-yellow-400 transition-colors text-lg"><i class="ri-facebook-fill"></i></a>
                <a href="#" class="hover:text-yellow-400 transition-colors text-lg"><i class="ri-twitter-fill"></i></a>
                <a href="#" class="hover:text-yellow-400 transition-colors text-lg"><i class="ri-instagram-line"></i></a>
            </div>
        </div>
    </div>
</footer>