document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm]').forEach((element) => {
        element.addEventListener('click', (event) => {
            if (!confirm(element.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    const nominal = document.getElementById('nominal_dibayar');
    const preview = document.getElementById('paymentPreview');

    if (nominal && preview) {
        const tariff = Number(nominal.dataset.tarif || 15000);
        const totalPaid = Number(nominal.dataset.total || 0);
        const requiredMonths = Number(nominal.dataset.bulanWajib || 0);

        const formatRupiah = (value) => Number(Math.max(0, Math.round(value))).toLocaleString('id-ID');

        const updatePreview = () => {
            const amount = Math.max(0, Number(nominal.value || 0));
            const totalAfter = totalPaid + amount;
            const paidMonths = Math.floor(totalAfter / tariff);
            const requiredTotal = requiredMonths * tariff;
            const shortage = Math.max(0, requiredTotal - totalAfter);
            const status = shortage <= 0 ? 'Lunas' : 'Menunggak';
            const remainingCredit = totalAfter % tariff;
            const coveredForCurrent = Math.min(requiredMonths, paidMonths);

            preview.innerHTML = `
                <div class="row g-2">
                    <div class="col-6">
                        <div class="small-muted">Status</div>
                        <span class="badge rounded-pill ${status === 'Lunas' ? 'badge-soft-success' : 'badge-soft-danger'}">${status}</span>
                    </div>
                    <div class="col-6">
                        <div class="small-muted">Bulan tercakup</div>
                        <strong>${coveredForCurrent} bulan</strong>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small-muted">Kekurangan</div>
                        <strong>Rp ${formatRupiah(shortage)}</strong>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="small-muted">Sisa nominal</div>
                        <strong>Rp ${formatRupiah(remainingCredit)}</strong>
                    </div>
                </div>
            `;
        };

        nominal.addEventListener('input', updatePreview);
        updatePreview();
    }
});
