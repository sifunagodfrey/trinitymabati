{{-- -------------------
     Client Topbar
------------------- --}}
<div class="bg-primary text-white text-sm">

    <div class="max-w-7xl mx-auto px-6 py-2 flex justify-between items-center">

        {{-- -------------------
             Welcome User
        ------------------- --}}
        <div class="font-medium">
            Welcome, {{ auth()->user()->name ?? 'User' }}
        </div>

        {{-- -------------------
             Company Info + Home
        ------------------- --}}
        <div class="flex items-center gap-6 text-xs md:text-sm">

            {{-- Phone --}}
            <div>
                +254 800-123-456
            </div>

            {{-- Email --}}
            <div>
                support@haromienergy.com
            </div>

        </div>

    </div>

</div>
