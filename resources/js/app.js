const sectionNames = {
    beranda: 'Beranda',
    kamar: 'Kamar',
    penyewa: 'Penyewa',
    tunggakan: 'Tunggakan',
    'listrik-air': 'Listrik & Air',
    perawatan: 'Perawatan',
    laporan: 'Laporan',
    pengaturan: 'Pengaturan',
};

document.querySelectorAll('.nav-item').forEach((item) => {
    item.addEventListener('click', () => {
        const target = item.dataset.section;

        document.querySelectorAll('.nav-item').forEach((nav) => nav.classList.toggle('active', nav === item));
        document.querySelectorAll('.section-panel').forEach((panel) => panel.classList.toggle('active', panel.id === target));

        const title = document.querySelector('#page-title');
        if (title) {
            title.textContent = sectionNames[target] ?? 'Beranda';
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

document.querySelectorAll('.segmented button').forEach((button) => {
    button.addEventListener('click', () => {
        button.parentElement.querySelectorAll('button').forEach((item) => item.classList.remove('active'));
        button.classList.add('active');
    });
});
