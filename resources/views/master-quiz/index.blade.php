<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Generator suara AI Master Quiz untuk Class of Champions — buat voiceover berwibawa layaknya announcer kompetisi epik menggunakan teknologi Azure Neural TTS.">
    <title>Master Quiz Voice Generator — Class of Champions</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts & CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/master-quiz.css') }}">
</head>
<body>

{{-- Animated Background --}}
<div class="bg-stars"></div>
<div class="bg-grid"></div>

<main class="container">

    {{-- ── HERO HEADER ── --}}
    <header class="hero">
        <div class="hero-badge">
            <span>⚡</span>
            <span>Class of Champions</span>
        </div>
        <h1 class="hero-title">Master Quiz<br>Voice Generator</h1>
        <p class="hero-subtitle">
            Ubah naskah soal kamu menjadi suara voiceover berwibawa,<br>
            dramatis, dan siap pakai — seperti suara di acara Clash of Champions.
        </p>
        <div class="hero-divider"></div>
    </header>

    {{-- ── TEMPLATE PRESETS ── --}}
    <section class="card" aria-label="Template naskah">
        <div class="card-label">
            <span class="dot"></span>
            Template Naskah
        </div>
        <div class="templates-grid">
            <button class="template-btn" id="tpl-opening"
                data-text="Selamat datang di Class of Champions! Hari ini, para juara terbaik akan bersaing untuk membuktikan siapa yang paling layak menyandang gelar Champion. Bersiaplah... pertarungan dimulai sekarang!">
                <span class="template-icon">🏆</span>
                <span class="template-name">Pembukaan</span>
                <span class="template-desc">Sambutan pembukaan kompetisi</span>
            </button>
            <button class="template-btn" id="tpl-soal"
                data-text="Perhatian! Soal nomor satu. Pertanyaan ini bernilai seratus poin. Siapkan dirimu... Sebutkan tiga cabang kekuasaan negara menurut teori Trias Politica! Waktu dimulai... sekarang!">
                <span class="template-icon">❓</span>
                <span class="template-name">Baca Soal</span>
                <span class="template-desc">Format pembacaan soal kompetisi</span>
            </button>
            <button class="template-btn" id="tpl-countdown"
                data-text="Waktu hampir habis! Lima... Empat... Tiga... Dua... Satu... Waktu habis! Pensil down, semua peserta harap berhenti menulis!">
                <span class="template-icon">⏱️</span>
                <span class="template-name">Countdown</span>
                <span class="template-desc">Hitung mundur dramatis</span>
            </button>
            <button class="template-btn" id="tpl-winner"
                data-text="Luar biasa! Dengan perolehan poin tertinggi, tim yang berhak menjadi Champion hari ini adalah... Hadirin, berikan tepuk tangan terkencang kalian untuk sang juara!">
                <span class="template-icon">🥇</span>
                <span class="template-name">Juara</span>
                <span class="template-desc">Pengumuman pemenang</span>
            </button>
            <button class="template-btn" id="tpl-rules"
                data-text="Sebelum kita mulai, dengarkan baik-baik peraturan pertandingan. Pertama, setiap tim mendapatkan satu kesempatan menjawab. Kedua, jawaban yang diterima hanya jawaban pertama yang disampaikan. Ketiga, keputusan juri bersifat final dan tidak dapat diganggu gugat.">
                <span class="template-icon">📋</span>
                <span class="template-name">Peraturan</span>
                <span class="template-desc">Penjelasan aturan permainan</span>
            </button>
            <button class="template-btn" id="tpl-wrong"
                data-text="Ooh, sayang sekali! Jawaban tersebut kurang tepat. Kesempatan diberikan kepada tim berikutnya. Apakah kalian tahu jawabannya?">
                <span class="template-icon">❌</span>
                <span class="template-name">Salah</span>
                <span class="template-desc">Respon jawaban salah</span>
            </button>
        </div>
    </section>

    {{-- ── NASKAH INPUT ── --}}
    <section class="card" aria-label="Input naskah">
        <div class="card-label">
            <span class="dot"></span>
            Naskah / Teks
        </div>
        <div class="textarea-wrapper">
            <textarea
                id="naskah-input"
                class="naskah-input"
                placeholder="Ketik atau tempel naskah soal kamu di sini...&#10;&#10;Contoh: Selamat datang di Class of Champions! Soal pertama, bernilai 100 poin..."
                maxlength="1000"
                aria-label="Naskah teks untuk diubah menjadi suara"
            ></textarea>
            <div class="char-counter" id="char-counter">0 / 1000</div>
        </div>
    </section>

    {{-- ── VOICE SETTINGS ── --}}
    <section class="card" aria-label="Pengaturan suara">
        <div class="card-label">
            <span class="dot"></span>
            Pengaturan Suara
        </div>
        <div class="settings-grid">
            {{-- Voice Select --}}
            <div class="setting-group">
                <label for="voice-select">🎤 Pilihan Suara</label>
                <select id="voice-select" class="voice-select" aria-label="Pilih jenis suara">
                    <optgroup label="🇮🇩 Bahasa Indonesia">
                        <option value="id-ID-ArdiNeural" selected>Ardi — Pria, Berwibawa (Rekomendasi)</option>
                        <option value="id-ID-GadisNeural">Gadis — Wanita, Natural</option>
                    </optgroup>
                    <optgroup label="🇺🇸 English (untuk soal B. Inggris)">
                        <option value="en-US-GuyNeural">Guy — Male, Deep & Formal</option>
                        <option value="en-US-ChristopherNeural">Christopher — Male, Authoritative</option>
                    </optgroup>
                </select>
            </div>

            {{-- Speed Slider --}}
            <div class="setting-group">
                <label for="rate-slider">⚡ Kecepatan Bicara</label>
                <div class="slider-container">
                    <div class="slider-value-row">
                        <span style="font-size:11px; color: var(--text-muted)">Lambat</span>
                        <span class="slider-value" id="rate-value">Normal</span>
                    </div>
                    <input type="range" id="rate-slider" min="-50" max="50" value="0"
                        step="5" aria-label="Kecepatan bicara">
                    <div class="slider-value-row">
                        <span></span>
                        <span style="font-size:11px; color: var(--text-muted)">Cepat</span>
                    </div>
                </div>
            </div>

            {{-- Pitch Slider --}}
            <div class="setting-group">
                <label for="pitch-slider">🎵 Nada Suara (Pitch)</label>
                <div class="slider-container">
                    <div class="slider-value-row">
                        <span style="font-size:11px; color: var(--text-muted)">Rendah (Deep)</span>
                        <span class="slider-value" id="pitch-value">Normal</span>
                    </div>
                    <input type="range" id="pitch-slider" min="-50" max="50" value="-5"
                        step="5" aria-label="Nada suara pitch">
                    <div class="slider-value-row">
                        <span></span>
                        <span style="font-size:11px; color: var(--text-muted)">Tinggi</span>
                    </div>
                </div>
            </div>

            {{-- Volume hint --}}
            <div class="setting-group">
                <label>💡 Tips Master Quiz</label>
                <div style="background: rgba(251,191,36,0.05); border: 1px solid rgba(251,191,36,0.15); border-radius: 8px; padding: 12px;">
                    <p style="font-size: 12px; color: var(--text-secondary); line-height: 1.6; margin: 0;">
                        Untuk hasil terbaik mirip Clash of Champions, gunakan:
                        <strong style="color: var(--gold-400);">Ardi</strong> dengan
                        <strong style="color: var(--gold-400);">kecepatan -10</strong> dan
                        <strong style="color: var(--gold-400);">pitch -10 hingga -15</strong>
                        untuk efek suara dalam dan dramatis.
                    </p>
                </div>
            </div>
        </div>

        {{-- Generate Button --}}
        <button class="generate-btn" id="generate-btn" type="button" aria-label="Generate voice">
            <div class="btn-content">
                <div class="spinner" id="btn-spinner"></div>
                <span class="btn-text" id="btn-text">⚡ Generate Voice</span>
            </div>
        </button>
    </section>

    {{-- ── AUDIO PLAYER ── --}}
    <section class="card player-card" id="player-card" aria-label="Audio player">
        <div class="card-label">
            <span class="dot"></span>
            Audio Hasil Generate
        </div>

        {{-- Waveform Visualizer --}}
        <div class="waveform paused" id="waveform">
            @for ($i = 0; $i < 15; $i++)
                <div class="wave-bar" style="height: {{ rand(8, 40) }}px;"></div>
            @endfor
        </div>

        {{-- Controls --}}
        <div class="player-controls">
            <button class="play-btn" id="play-btn" aria-label="Play / Pause">
                ▶
            </button>
            <div class="progress-wrapper">
                <div class="progress-bar-container" id="progress-container" role="slider" aria-label="Progress audio">
                    <div class="progress-bar" id="progress-bar"></div>
                </div>
                <div class="time-display">
                    <span id="time-current">0:00</span>
                    <span id="time-total">0:00</span>
                </div>
            </div>
            <a class="download-btn" id="download-btn" download="master-quiz-audio.mp3" aria-label="Download MP3">
                ⬇ Download MP3
            </a>
        </div>

        {{-- Hidden native audio --}}
        <audio id="audio-player" preload="auto"></audio>
    </section>

</main>

<footer class="footer">
    <p>Dibuat dengan <span>⚡</span> oleh <span>Class of Champions</span> — Powered by Microsoft Azure Edge TTS (Gratis)</p>
</footer>

{{-- Toast notification --}}
<div class="toast" id="toast" role="alert" aria-live="polite"></div>

<script>
    // ── CSRF Token ──────────────────────────────────────────────
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const GENERATE_URL = "{{ route('master-quiz.generate') }}";

    // ── Elements ────────────────────────────────────────────────
    const naskahInput  = document.getElementById('naskah-input');
    const charCounter  = document.getElementById('char-counter');
    const generateBtn  = document.getElementById('generate-btn');
    const btnText      = document.getElementById('btn-text');
    const btnSpinner   = document.getElementById('btn-spinner');
    const playerCard   = document.getElementById('player-card');
    const audioPlayer  = document.getElementById('audio-player');
    const playBtn      = document.getElementById('play-btn');
    const progressBar  = document.getElementById('progress-bar');
    const progressCont = document.getElementById('progress-container');
    const timeCurrent  = document.getElementById('time-current');
    const timeTotal    = document.getElementById('time-total');
    const downloadBtn  = document.getElementById('download-btn');
    const waveform     = document.getElementById('waveform');
    const rateSlider   = document.getElementById('rate-slider');
    const pitchSlider  = document.getElementById('pitch-slider');
    const rateValue    = document.getElementById('rate-value');
    const pitchValue   = document.getElementById('pitch-value');
    const toast        = document.getElementById('toast');

    // ── Character Counter ────────────────────────────────────────
    naskahInput.addEventListener('input', () => {
        const len = naskahInput.value.length;
        charCounter.textContent = `${len} / 1000`;
        charCounter.className = 'char-counter' +
            (len > 900 ? ' danger' : len > 700 ? ' warning' : '');
    });

    // ── Template Buttons ─────────────────────────────────────────
    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            naskahInput.value = btn.dataset.text;
            naskahInput.dispatchEvent(new Event('input'));
            naskahInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            naskahInput.focus();
        });
    });

    // ── Slider Display Update ─────────────────────────────────────
    function updateSlider(slider, displayEl, unit) {
        const val = parseInt(slider.value);
        if (val === 0)       displayEl.textContent = 'Normal';
        else if (val > 0)    displayEl.textContent = `+${val}${unit}`;
        else                 displayEl.textContent = `${val}${unit}`;

        // Track fill
        const pct = ((val - parseInt(slider.min)) / (parseInt(slider.max) - parseInt(slider.min))) * 100;
        slider.style.setProperty('--slider-percent', pct + '%');
    }

    rateSlider.addEventListener('input', () => updateSlider(rateSlider, rateValue, '%'));
    pitchSlider.addEventListener('input', () => updateSlider(pitchSlider, pitchValue, 'Hz'));
    updateSlider(rateSlider, rateValue, '%');
    updateSlider(pitchSlider, pitchValue, 'Hz');

    // ── Generate Audio ────────────────────────────────────────────
    generateBtn.addEventListener('click', async () => {
        const text = naskahInput.value.trim();
        if (!text) {
            showToast('error', '⚠️ Masukkan naskah teks terlebih dahulu!');
            naskahInput.focus();
            return;
        }

        // Build rate & pitch strings for edge-tts
        const rateVal  = parseInt(rateSlider.value);
        const pitchVal = parseInt(pitchSlider.value);
        const rateStr  = (rateVal >= 0 ? '+' : '') + rateVal + '%';
        const pitchStr = (pitchVal >= 0 ? '+' : '') + pitchVal + 'Hz';

        setLoading(true);

        try {
            const response = await fetch(GENERATE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    text:  text,
                    voice: document.getElementById('voice-select').value,
                    rate:  rateStr,
                    pitch: pitchStr,
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Terjadi kesalahan pada server.');
            }

            // Load audio
            audioPlayer.src = data.url;
            downloadBtn.href = data.url;
            downloadBtn.download = data.filename || 'master-quiz-audio.mp3';

            // Show player
            playerCard.classList.add('visible');
            playerCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            // Auto-play
            await audioPlayer.play();
            showToast('success', '✅ Audio berhasil di-generate! Sedang diputar...');

        } catch (err) {
            console.error(err);
            showToast('error', '❌ Gagal: ' + err.message);
        } finally {
            setLoading(false);
        }
    });

    // ── Loading State ─────────────────────────────────────────────
    function setLoading(isLoading) {
        generateBtn.disabled = isLoading;
        generateBtn.classList.toggle('loading', isLoading);
        btnSpinner.style.display = isLoading ? 'block' : 'none';
        btnText.textContent = isLoading ? 'Generating...' : '⚡ Generate Voice';
    }

    // ── Audio Player Controls ─────────────────────────────────────
    playBtn.addEventListener('click', () => {
        if (audioPlayer.paused) {
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
    });

    audioPlayer.addEventListener('play', () => {
        playBtn.textContent = '⏸';
        waveform.classList.remove('paused');
    });

    audioPlayer.addEventListener('pause', () => {
        playBtn.textContent = '▶';
        waveform.classList.add('paused');
    });

    audioPlayer.addEventListener('ended', () => {
        playBtn.textContent = '▶';
        waveform.classList.add('paused');
        progressBar.style.width = '0%';
        timeCurrent.textContent = '0:00';
    });

    audioPlayer.addEventListener('timeupdate', () => {
        if (!audioPlayer.duration || isDragging) return;
        const pct = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.style.width = pct + '%';
        timeCurrent.textContent = formatTime(audioPlayer.currentTime);
    });

    audioPlayer.addEventListener('loadedmetadata', () => {
        timeTotal.textContent = formatTime(audioPlayer.duration);
    });

    // Pointer events for dragging / scrubbing to seek
    let isDragging = false;
    let wasPlayingBeforeDrag = false;

    function setProgressFromEvent(e) {
        if (!audioPlayer.duration) return;
        const rect = progressCont.getBoundingClientRect();
        let pct  = (e.clientX - rect.left) / rect.width;
        pct = Math.max(0, Math.min(1, pct));
        audioPlayer.currentTime = pct * audioPlayer.duration;
        
        progressBar.style.width = (pct * 100) + '%';
        timeCurrent.textContent = formatTime(audioPlayer.currentTime);
    }

    progressCont.addEventListener('pointerdown', (e) => {
        if (!audioPlayer.duration) return;
        isDragging = true;
        wasPlayingBeforeDrag = !audioPlayer.paused;
        if (wasPlayingBeforeDrag) audioPlayer.pause();
        
        progressCont.setPointerCapture(e.pointerId);
        setProgressFromEvent(e);
    });

    progressCont.addEventListener('pointermove', (e) => {
        if (isDragging) {
            setProgressFromEvent(e);
        }
    });

    progressCont.addEventListener('pointerup', (e) => {
        if (!isDragging) return;
        isDragging = false;
        progressCont.releasePointerCapture(e.pointerId);
        if (wasPlayingBeforeDrag) audioPlayer.play();
    });

    progressCont.addEventListener('pointercancel', (e) => {
        if (!isDragging) return;
        isDragging = false;
        progressCont.releasePointerCapture(e.pointerId);
    });

    function formatTime(sec) {
        const m = Math.floor(sec / 60);
        const s = Math.floor(sec % 60);
        return `${m}:${s.toString().padStart(2, '0')}`;
    }

    // ── Waveform Randomization ────────────────────────────────────
    // Give each bar a random height for organic look
    document.querySelectorAll('.wave-bar').forEach(bar => {
        const randomH = 8 + Math.random() * 36;
        bar.style.setProperty('--base-height', randomH + 'px');
    });

    // ── Toast Helper ──────────────────────────────────────────────
    let toastTimer = null;
    function showToast(type, message) {
        toast.className = `toast ${type} show`;
        toast.textContent = message;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }
</script>
</body>
</html>
