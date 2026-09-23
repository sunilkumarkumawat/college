@php
    $setting = DB::table('settings')->get()->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!empty($setting))
        <title>{{ $setting->name ?? ' Shri Girraj Educational and Welfare Society ' }}</title>
        <link rel="icon" type="image/x-icon" href="{{ env('IMAGE_SHOW_PATH').'setting/left_logo/'.$setting->left_logo ?? '' }}" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/mini_logo.png' }}'">
    @else
        <title> Shri Girraj Educational and Welfare Society </title>
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('public/assets/school/css/toastr.min.css') }}">
    <script src="{{ asset('public/assets/school/js/toastr.min.js') }}"></script>

    <style>
        :root{
            --navy-1:#0a1230;
            --navy-2:#122a52;
            --teal-1:#0fb8c9;
            --teal-2:#22e6b8;
            --mint:#8ef7dc;
            --violet:#7c6cf2;
            --ink:#0e1a2b;
            --muted:#5c7186;
            --danger:#e5533d;
            --glass-bg:rgba(255,255,255,0.62);
            --glass-border:rgba(255,255,255,0.55);
            --dur-fast:0.22s;
            --dur-med:0.5s;
            --radius-lg:20px;
        }

        *{box-sizing:border-box;}
        body{margin:0;min-height:100vh;font-family:'Inter',sans-serif;color:var(--ink);overflow-x:hidden;}

        .bg-photo{
            position:fixed;inset:0;z-index:-4;
            background-image:url('{{ env('IMAGE_SHOW_PATH').'default/Icon_images/ShriGirrajBg.jpg' }}');
            background-size:cover;
            background-position:center;
        }

        .bg-canvas{
            position:fixed;inset:0;z-index:-3;
            background:linear-gradient(125deg,rgba(10,18,48,0.88) 0%,rgba(18,42,82,0.82) 30%,rgba(15,184,201,0.78) 68%,rgba(34,230,184,0.78) 100%);
            background-size:220% 220%;
            animation:gradientShift 12s ease-in-out infinite;
        }
        @keyframes gradientShift{0%,100%{background-position:0% 40%;}50%{background-position:100% 60%;}}

        .bg-grid{
            position:fixed;inset:0;z-index:-2;
            background-image:
                linear-gradient(rgba(255,255,255,0.05) 1px,transparent 1px),
                linear-gradient(90deg,rgba(255,255,255,0.05) 1px,transparent 1px);
            background-size:42px 42px;
            mask-image:radial-gradient(ellipse 80% 60% at 30% 40%,#000 40%,transparent 85%);
        }

        .blob{position:fixed;border-radius:50%;filter:blur(60px);z-index:-1;opacity:0.55;animation:blobDrift 14s ease-in-out infinite;}
        .blob.b1{width:420px;height:420px;top:-10%;left:-8%;background:radial-gradient(circle,var(--mint),transparent 70%);}
        .blob.b2{width:360px;height:360px;bottom:-12%;right:-6%;background:radial-gradient(circle,var(--teal-1),transparent 70%);animation-delay:2.2s;}
        .blob.b3{width:280px;height:280px;top:36%;left:44%;background:radial-gradient(circle,var(--violet),transparent 72%);opacity:0.18;animation-delay:1s;}
        @keyframes blobDrift{0%,100%{transform:translate(0,0) scale(1);}50%{transform:translate(24px,-18px) scale(1.06);}}

        .spotlight{
            position:absolute;inset:0;z-index:0;pointer-events:none;
            background:radial-gradient(360px circle at var(--sx,50%) var(--sy,40%),rgba(255,255,255,0.14),transparent 60%);
            transition:background var(--dur-fast) ease;
        }

        .shell-row{min-height:100vh;margin:0;}

        /* ---------------- LEFT: STORY PANEL ---------------- */
        .story-col{display:flex;flex-direction:column;justify-content:center;padding:64px 68px;position:relative;color:#fff;overflow:hidden;}

        .brand-chip{
            display:inline-flex;align-items:center;gap:10px;width:fit-content;
            padding:8px 14px;border-radius:999px;
            background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.28);
            font-family:'Manrope',sans-serif;font-weight:600;font-size:0.78rem;letter-spacing:0.03em;
            position:relative;z-index:1;
        }
        .brand-chip .live-dot{width:6px;height:6px;border-radius:50%;background:var(--mint);box-shadow:0 0 0 0 rgba(142,247,220,0.6);animation:livePulse 1.8s infinite;}
        @keyframes livePulse{0%{box-shadow:0 0 0 0 rgba(142,247,220,0.6);}70%{box-shadow:0 0 0 7px rgba(142,247,220,0);}100%{box-shadow:0 0 0 0 rgba(142,247,220,0);}}

        .story-heading{font-family:'Manrope',sans-serif;font-weight:800;font-size:clamp(2.1rem,3vw,2.9rem);line-height:1.16;margin:26px 0 16px;max-width:11em;letter-spacing:-0.01em;position:relative;z-index:1;}
        .story-heading .grad-word{
            background:linear-gradient(100deg,var(--mint) 10%,var(--teal-1) 50%,var(--violet) 90%);
            background-size:220% auto;-webkit-background-clip:text;background-clip:text;color:transparent;
            animation:shimmer 6s ease-in-out infinite;
        }
        @keyframes shimmer{0%,100%{background-position:0% 50%;}50%{background-position:100% 50%;}}

        .story-sub{font-size:1rem;line-height:1.7;color:rgba(255,255,255,0.78);max-width:30em;margin-bottom:40px;position:relative;z-index:1;}

        .ekg-wrap{
            width:100%;max-width:460px;height:110px;overflow:hidden;position:relative;margin-bottom:40px;z-index:1;
            -webkit-mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
            mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
        }
        .ekg-track{position:absolute;top:0;left:0;height:100%;width:200%;animation:ekgScroll 6s linear infinite;}
        .ekg-track svg{height:100%;width:100%;display:block;}
        .ekg-line{fill:none;stroke:url(#ekgGradient);stroke-width:2.4;stroke-linecap:round;stroke-linejoin:round;filter:drop-shadow(0 0 8px rgba(142,247,220,0.65));}
        @keyframes ekgScroll{from{transform:translateX(0);}to{transform:translateX(-50%);}}

        .floaty-icons{position:absolute;inset:0;pointer-events:none;z-index:0;}
        .floaty-icons i{position:absolute;color:rgba(255,255,255,0.22);animation:floaty 6s ease-in-out infinite;}
        .floaty-icons i:nth-child(1){top:14%;right:16%;font-size:1.7rem;}
        .floaty-icons i:nth-child(2){top:64%;right:8%;font-size:1.3rem;animation-delay:1.2s;color:rgba(142,247,220,0.3);}
        .floaty-icons i:nth-child(3){top:80%;right:30%;font-size:1.1rem;animation-delay:2.4s;}
        .floaty-icons i:nth-child(4){top:8%;right:42%;font-size:1rem;animation-delay:3.1s;color:rgba(124,108,242,0.3);}
        @keyframes floaty{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-14px) rotate(6deg);}}

        .story-stats{position:relative;z-index:1;display:flex;gap:34px;margin-top:auto;padding-top:22px;border-top:1px solid rgba(255,255,255,0.18);}
        .story-stats .stat b{display:block;font-family:'Manrope',sans-serif;font-weight:800;font-size:1.3rem;}
        .story-stats .stat span{font-size:0.74rem;color:rgba(255,255,255,0.65);text-transform:uppercase;letter-spacing:0.06em;}

        .hud-line{position:relative;z-index:1;margin-top:16px;font-family:'JetBrains Mono',monospace;font-size:0.68rem;letter-spacing:0.05em;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:8px;}
        .hud-line .hd{width:6px;height:6px;border-radius:50%;background:var(--mint);animation:livePulse 1.8s infinite;}

        /* ---------------- RIGHT: FORM PANEL ---------------- */
        .form-col{display:flex;align-items:center;justify-content:center;padding:40px 24px;position:relative;}
        .card-frame{position:relative;width:100%;max-width:420px;}

        .hud-corner{position:absolute;width:22px;height:22px;pointer-events:none;z-index:2;animation:hudBreathe 3s ease-in-out infinite;}
        .hud-corner.tl{top:-9px;left:-9px;border-top:2px solid var(--mint);border-left:2px solid var(--mint);border-top-left-radius:8px;}
        .hud-corner.tr{top:-9px;right:-9px;border-top:2px solid var(--mint);border-right:2px solid var(--mint);border-top-right-radius:8px;animation-delay:0.4s;}
        .hud-corner.bl{bottom:-9px;left:-9px;border-bottom:2px solid var(--mint);border-left:2px solid var(--mint);border-bottom-left-radius:8px;animation-delay:0.8s;}
        .hud-corner.br{bottom:-9px;right:-9px;border-bottom:2px solid var(--mint);border-right:2px solid var(--mint);border-bottom-right-radius:8px;animation-delay:1.2s;}
        @keyframes hudBreathe{0%,100%{opacity:0.35;}50%{opacity:1;}}

        .glass-card{
            position:relative;z-index:1;
            background:var(--glass-bg);
            border:1px solid var(--glass-border);
            border-radius:var(--radius-lg);
            padding:0 38px 30px;
            backdrop-filter:blur(22px) saturate(160%);
            -webkit-backdrop-filter:blur(22px) saturate(160%);
            box-shadow:0 30px 60px -20px rgba(10,31,58,0.45);
            transform-style:preserve-3d;
            transition:transform var(--dur-fast) ease, box-shadow var(--dur-fast) ease;
            overflow:hidden;
        }

        .glass-card::after{
            content:"";
            position:absolute;left:0;right:0;height:2px;
            background:linear-gradient(90deg,transparent,var(--mint),transparent);
            opacity:0.55;top:-5%;
            animation:scanSweep 4.2s linear infinite;
            filter:blur(0.4px);
            pointer-events:none;
        }
        @keyframes scanSweep{0%{top:-4%;}100%{top:104%;}}

        @keyframes cardShake{0%,100%{transform:translateX(0);}20%{transform:translateX(-8px);}40%{transform:translateX(7px);}60%{transform:translateX(-5px);}80%{transform:translateX(3px);}}
        .shake-error{animation:cardShake 0.5s ease;}
        @keyframes glowPulse{0%,100%{box-shadow:0 30px 60px -20px rgba(10,31,58,0.45),0 0 0 0 rgba(229,83,61,0);}50%{box-shadow:0 30px 60px -20px rgba(10,31,58,0.45),0 0 0 8px rgba(229,83,61,0.18);}}
        .glow-error{animation:glowPulse 1.4s ease 2;}

        [data-reveal]{opacity:0;transform:translateY(16px);animation:revealUp var(--dur-med) cubic-bezier(.2,.7,.25,1) forwards;animation-delay:var(--d,0ms);}
        @keyframes revealUp{to{opacity:1;transform:translateY(0);}}

        .os-titlebar{
            display:flex;align-items:center;gap:6px;
            padding:13px 18px;
            margin:0 0 26px;
            background:rgba(14,26,43,0.05);
            border-bottom:1px solid rgba(14,26,43,0.08);
        }
        .os-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
        .os-label{flex:1;text-align:center;font-family:'JetBrains Mono',monospace;font-size:0.62rem;letter-spacing:0.09em;text-transform:uppercase;color:var(--muted);}
        .os-lock{font-size:0.68rem;color:var(--muted);}

        .logo-orbit{position:relative;width:56px;height:56px;margin-bottom:6px;}
        .logo-orbit::before,.logo-orbit::after{
            content:"";position:absolute;inset:0;border-radius:50%;
            border:1.5px solid var(--teal-1);opacity:0;
            animation:sonarPing 2.6s ease-out infinite;
        }
        .logo-orbit::after{animation-delay:1.3s;}
        @keyframes sonarPing{0%{transform:scale(1);opacity:0.55;}100%{transform:scale(2);opacity:0;}}
        .card-logo{
            width:56px;height:56px;border-radius:14px;
            display:inline-flex;align-items:center;justify-content:center;
            background:linear-gradient(150deg,var(--teal-1),var(--violet));
            color:#fff;font-size:1.3rem;overflow:hidden;
            box-shadow:0 10px 22px -8px rgba(18,58,92,0.5);
            position:relative;z-index:1;
        }
        .card-logo img{width:100%;height:100%;object-fit:cover;}

        .boot-line{font-family:'JetBrains Mono',monospace;font-size:0.72rem;letter-spacing:0.02em;color:var(--teal-1);margin:14px 0 0;min-height:1.1em;}
        .boot-line::after{content:"▋";margin-left:2px;animation:blink 0.9s steps(1) infinite;}
        @keyframes blink{50%{opacity:0;}}

        .card-title{font-family:'Manrope',sans-serif;font-weight:800;font-size:1.5rem;margin:14px 0 4px;color:var(--navy-1);}
        .card-sub{font-size:0.86rem;color:var(--muted);margin-bottom:24px;}

        .alert-error{display:flex;align-items:flex-start;gap:9px;font-size:0.82rem;padding:11px 13px;border-radius:10px;background:rgba(229,83,61,0.1);border:1px solid rgba(229,83,61,0.3);color:#a83a26;margin-bottom:18px;}

        .fl-group{position:relative;margin-bottom:22px;}
        .fl-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:0.92rem;transition:color var(--dur-fast) ease, transform var(--dur-fast) ease;z-index:2;}
        .fl-input{width:100%;padding:20px 14px 8px 42px;border-radius:12px;border:1.5px solid rgba(14,34,51,0.14);background:rgba(255,255,255,0.75);font-size:0.95rem;font-family:'Inter',sans-serif;color:var(--ink);transition:border-color var(--dur-fast) ease, box-shadow var(--dur-fast) ease, background var(--dur-fast) ease;}
        .fl-input.is-invalid{border-color:var(--danger);}
        .fl-input::placeholder{color:transparent;}
        .fl-label{position:absolute;left:42px;top:50%;transform:translateY(-50%);font-size:0.92rem;color:var(--muted);pointer-events:none;transition:all var(--dur-fast) ease;}
        .fl-input:focus{outline:none;border-color:var(--teal-1);background:#fff;box-shadow:0 0 0 4px rgba(15,184,201,0.16);}
        .fl-input:focus ~ .fl-label,.fl-input:not(:placeholder-shown) ~ .fl-label{top:11px;font-size:0.68rem;font-weight:600;letter-spacing:0.02em;color:var(--teal-1);}
        .fl-input:focus ~ .fl-icon{color:var(--teal-1);transform:translateY(-50%) scale(1.1);}
        .fl-error{display:block;width:100%;margin-top:6px;font-size:0.74rem;color:var(--danger);min-height:1em;}

        .fl-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:var(--muted);cursor:pointer;padding:4px;z-index:2;}
        .fl-toggle:hover{color:var(--teal-1);}

        /* animated gradient underline that sweeps in on focus */
        .fl-underline{
            position:absolute;left:18px;right:18px;bottom:0;height:2px;border-radius:2px;
            background:linear-gradient(90deg,var(--teal-1),var(--violet));
            transform:scaleX(0);transform-origin:center;
            transition:transform 0.45s cubic-bezier(.16,1,.3,1);
            z-index:2;pointer-events:none;
        }
        .fl-input:focus ~ .fl-underline{transform:scaleX(1);}

        .submit-btn{
            width:100%;border:0;border-radius:12px;padding:14px;
            font-family:'Manrope',sans-serif;font-weight:700;font-size:0.95rem;color:#fff;cursor:pointer;
            background:linear-gradient(135deg,var(--navy-2),var(--teal-1));
            box-shadow:0 14px 26px -12px rgba(18,58,92,0.55);
            transition:transform var(--dur-fast) ease, box-shadow var(--dur-fast) ease;
            display:flex;align-items:center;justify-content:center;gap:9px;min-height:50px;
            position:relative;overflow:hidden;
        }
        .submit-btn:hover{box-shadow:0 18px 30px -12px rgba(18,58,92,0.6);}
        .submit-btn:disabled{cursor:default;opacity:0.85;}

        .status-readout{margin-top:12px;text-align:center;font-family:'JetBrains Mono',monospace;font-size:0.66rem;letter-spacing:0.06em;color:var(--muted);transition:color var(--dur-fast) ease;}
        .status-readout.is-loading{color:var(--teal-1);}
        .status-readout.is-success{color:#1f9d6f;}

        .powered-by{margin-top:20px;text-align:center;font-family:'Inter',sans-serif;font-size:0.72rem;color:rgba(14,34,51,0.4);letter-spacing:0.02em;padding-bottom:6px;}
        .powered-by b{color:rgba(14,34,51,0.62);font-weight:700;}

        @media (max-width:991.98px){
            .story-col{display:none;}
            .form-col{padding:28px 18px;min-height:100vh;}
        }
        @media (prefers-reduced-motion: reduce){
            *{animation:none !important;transition:none !important;}
            [data-reveal]{opacity:1 !important;transform:none !important;}
            .glass-card{transform:none !important;}
        }
    </style>
</head>
<body x-data="loginPage()" x-init="init()">

<div class="bg-photo"></div>
<div class="bg-canvas"></div>
<div class="bg-grid"></div>
<div class="blob b1"></div>
<div class="blob b2"></div>
<div class="blob b3"></div>

<div class="container-fluid">
    <div class="row shell-row">

        <!-- LEFT: STORY PANEL -->
        <div class="col-lg-6 story-col" @mousemove="spot($event)">
            <div class="spotlight" x-bind:style="`--sx:${sx}%;--sy:${sy}%`"></div>

            <div class="floaty-icons">
                <i class="fa-solid fa-graduation-cap"></i>
                <i class="fa-solid fa-book-open"></i>
                <i class="fa-solid fa-building-columns"></i>
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <div class="brand-chip" data-reveal style="--d:0ms">
                <span class="live-dot"></span>
                @if(!empty($setting)){{ $setting->name ?? 'Shri Girraj Educational and Welfare Society' }}@else Shri Girraj Educational and Welfare Society @endif
            </div>

            <h1 class="story-heading" data-reveal style="--d:100ms">
                One login for campus, academics &amp; every <span class="grad-word">student.</span>
            </h1>
            <p class="story-sub" data-reveal style="--d:200ms">
                Admissions, academics, attendance and administration — all in one secure portal for Shri Girraj faculty, staff and students.
            </p>

            <div class="ekg-wrap" data-reveal style="--d:300ms">
                <div class="ekg-track">
                    <svg viewBox="0 0 600 110" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="ekgGradient" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#8ef7dc" stop-opacity="0.2"/>
                                <stop offset="50%" stop-color="#8ef7dc" stop-opacity="1"/>
                                <stop offset="100%" stop-color="#8ef7dc" stop-opacity="0.2"/>
                            </linearGradient>
                        </defs>
                        <path class="ekg-line" d="M0,80 C40,80 50,70 70,55 C90,40 100,20 130,25 C160,30 165,60 190,60 C220,60 230,15 265,15 C300,15 305,50 335,50 C365,50 375,25 410,25 C445,25 455,65 490,65 C525,65 535,35 570,35 C585,35 595,40 600,45"></path>
                        <path class="ekg-line" d="M0,80 C40,80 50,70 70,55 C90,40 100,20 130,25 C160,30 165,60 190,60 C220,60 230,15 265,15 C300,15 305,50 335,50 C365,50 375,25 410,25 C445,25 455,65 490,65 C525,65 535,35 570,35 C585,35 595,40 600,45" transform="translate(600,0)"></path>
                    </svg>
                </div>
            </div>

            <!--<div class="story-stats" data-reveal style="--d:380ms">-->
            <!--    <div class="stat"><b>MBBS</b><span>&amp; Allied Courses</span></div>-->
            <!--    <div class="stat"><b>24/7</b><span>Campus Access</span></div>-->
            <!--    <div class="stat"><b>100%</b><span>Digital Records</span></div>-->
            <!--</div>-->

            <div class="hud-line" data-reveal style="--d:420ms">
                <span class="hd"></span> SECURE CONNECTION · TLS · <span x-text="clock"></span>
            </div>
        </div>

        <!-- RIGHT: FORM PANEL -->
        <div class="col-lg-6 form-col">
            <div class="card-frame" data-reveal style="--d:80ms">
                <span class="hud-corner tl"></span>
                <span class="hud-corner tr"></span>
                <span class="hud-corner bl"></span>
                <span class="hud-corner br"></span>

                <div class="glass-card"
                     x-ref="card"
                     @mousemove="tilt($event)"
                     @mouseleave="resetTilt()"
                     x-bind:class="{ 'shake-error glow-error': hasError }">

                    <div class="os-titlebar">
                        <span class="os-dot" style="background:var(--mint)"></span>
                        <span class="os-dot" style="background:var(--teal-1)"></span>
                        <span class="os-dot" style="background:var(--violet)"></span>
                        <span class="os-label">Shri Girraj · Secure Login</span>
                        <i class="fa-solid fa-lock os-lock"></i>
                    </div>

                    <div>
                        <div class="logo-orbit">
                            <span class="card-logo">
                                @if(!empty($setting) && !empty($setting->left_logo))
                                    <img src="{{ env('IMAGE_SHOW_PATH').'setting/left_logo/'.$setting->left_logo }}" alt="Logo" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fa-solid fa-graduation-cap\'></i>'">
                                @else
                                    <i class="fa-solid fa-graduation-cap"></i>
                                @endif
                            </span>
                        </div>
                        <p class="boot-line" x-show="showBoot" x-text="bootText" x-cloak></p>

                        <h2 class="card-title" data-reveal style="--d:180ms">Welcome back</h2>
                        <p class="card-sub" data-reveal style="--d:220ms">Sign in to your Shri Girraj account</p>

                        @include('layout.message')

                        <form id="loginForm" action="{{ url('login') }}" method="POST" @submit="handleSubmit">
                            @csrf

                            <div class="fl-group" data-reveal style="--d:280ms">
                                <i class="fa-solid fa-user fl-icon"></i>
                                <input id="user_name" name="user_name" type="text" class="fl-input @error('user_name') is-invalid @enderror"
                                       placeholder=" " value="{{ old('user_name') }}" autocomplete="username">
                                <label for="user_name" class="fl-label">User Name</label>
                                <span class="fl-error" id="user_name_error"></span>
                                <span class="fl-underline"></span>
                            </div>

                            <div class="fl-group" data-reveal style="--d:320ms">
                                <i class="fa-solid fa-lock fl-icon"></i>
                                <input id="password" name="password" x-bind:type="showPassword ? 'text' : 'password'"
                                       class="fl-input @error('password') is-invalid @enderror" placeholder=" " autocomplete="current-password">
                                <label for="password" class="fl-label">Password</label>
                                <button type="button" class="fl-toggle" @click="showPassword = !showPassword">
                                    <i class="fa-solid" x-bind:class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                                <span class="fl-error" id="password_error"></span>
                                <span class="fl-underline"></span>
                            </div>

                            <button type="submit" class="submit-btn" id="submitBtn" data-reveal style="--d:400ms"
                                    @mousemove="magnet($event)" @mouseleave="resetMagnet($event)"
                                    x-bind:disabled="btnState !== 'idle'">
                                <template x-if="btnState === 'idle'">
                                    <span><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign in</span>
                                </template>
                                <template x-if="btnState === 'loading'">
                                    <span><i class="fa-solid fa-circle-notch fa-spin"></i> Signing in…</span>
                                </template>
                                <template x-if="btnState === 'success'">
                                    <span><i class="fa-solid fa-check"></i> Success</span>
                                </template>
                            </button>

                            <p class="status-readout"
                               x-bind:class="{'is-loading': btnState==='loading', 'is-success': btnState==='success'}"
                               x-text="btnState==='loading' ? 'STATUS: VERIFYING CREDENTIALS' : (btnState==='success' ? 'STATUS: ACCESS GRANTED' : 'STATUS: AWAITING INPUT')">
                            </p>
                        </form>

                        <div class="powered-by" data-reveal style="--d:480ms">
                            Powered by <b>Rukmani Software</b> · Jaipur
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function loginPage(){
        return {
            showPassword:false,
            btnState:'idle',
            hasError:{{ $errors->any() ? 'true' : 'false' }},
            sx:50, sy:40,
            clock:'',
            canInteract:false,
            showBoot:true,
            bootText:'',
            init(){
                this.canInteract = window.matchMedia('(pointer: fine)').matches
                    && window.matchMedia('(prefers-reduced-motion: no-preference)').matches;

                if (this.hasError) setTimeout(() => { this.hasError = false; }, 1400);

                const tick = () => { this.clock = new Date().toLocaleTimeString('en-IN', { hour12:false }); };
                tick();
                setInterval(tick, 1000);

                this.typeBoot();
            },
            typeBoot(){
                const full = 'Initializing secure session…';
                let i = 0;
                const iv = setInterval(() => {
                    this.bootText = full.slice(0, i + 1);
                    i++;
                    if (i >= full.length) {
                        clearInterval(iv);
                        setTimeout(() => { this.showBoot = false; }, 650);
                    }
                }, 26);
            },
            spot(e){
                if (!this.canInteract) return;
                const r = e.currentTarget.getBoundingClientRect();
                this.sx = ((e.clientX - r.left) / r.width * 100).toFixed(1);
                this.sy = ((e.clientY - r.top) / r.height * 100).toFixed(1);
            },
            tilt(e){
                if (!this.canInteract) return;
                const card = this.$refs.card;
                const r = card.getBoundingClientRect();
                const rx = ((e.clientY - r.top - r.height/2) / r.height) * -6;
                const ry = ((e.clientX - r.left - r.width/2) / r.width) * 6;
                card.style.transform = `rotateX(${rx.toFixed(2)}deg) rotateY(${ry.toFixed(2)}deg) translateZ(0)`;
            },
            resetTilt(){ this.$refs.card.style.transform = ''; },
            magnet(e){
                if (!this.canInteract) return;
                const btn = e.currentTarget;
                const r = btn.getBoundingClientRect();
                const x = (e.clientX - r.left - r.width/2) * 0.1;
                const y = (e.clientY - r.top - r.height/2) * 0.3;
                btn.style.transform = `translate(${x.toFixed(1)}px,${y.toFixed(1)}px)`;
            },
            resetMagnet(e){ e.currentTarget.style.transform = ''; },
            handleSubmit(e){
                // Real submission is handled by the jQuery AJAX block below.
                // This just drives the button's visual state; e.preventDefault()
                // happens in the jQuery handler, not here.
            }
        }
    }

    // ---- Original AJAX login logic (kept 1:1 from the existing login flow) ----
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();

            var form = $(this);
            var submitButton = $('#submitBtn');
            var alpineRoot = document.body.__x ? document.body.__x.$data : null;

            if (alpineRoot) alpineRoot.btnState = 'loading';
            submitButton.prop('disabled', true);

            var data = form.serialize();
            $('#user_name_error').text('');
            $('#password_error').text('');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: data,
                success: function (response) {
                    submitButton.prop('disabled', false);
                    if (response.status === 'success') {
                        if (alpineRoot) alpineRoot.btnState = 'success';
                        toastr.success(response.message);
                        window.location.href = response.redirect_url;
                    } else {
                        if (alpineRoot) alpineRoot.btnState = 'idle';
                        $('#user_name_error').text(response.user_name_error);
                        $('#password_error').text(response.password_error);
                        if (alpineRoot) alpineRoot.hasError = true;
                        if (response.message == "") {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function (xhr) {
                    submitButton.prop('disabled', false);
                    if (alpineRoot) { alpineRoot.btnState = 'idle'; alpineRoot.hasError = true; }
                    var errors = xhr.responseJSON ? xhr.responseJSON.errors : {};
                    $('#user_name_error').text(errors && errors.user_name ? errors.user_name[0] : '');
                    $('#password_error').text(errors && errors.password ? errors.password[0] : '');
                }
            });
        });
    });
</script>

</body>
</html>