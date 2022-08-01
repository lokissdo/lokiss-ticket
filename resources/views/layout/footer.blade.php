<div class="footer-overlay"></div>
<footer class="footer position-fixed d-flex flex-column-reverse">
    <div class="footer-basic align-self-end">
        <p class="copyright">2022 - {{ date('Y') }} © {{ config('app.name') }} - Lokiss </p>

    </div>
</footer>
<style>
    .footer-overlay {
        height: var(--footer-height);
    }

    footer {
        height: var(--footer-height);
        bottom: 0;
        left: 0;
        right: 0;
        margin-left: var(--sidebar-width);
    }

    .footer-basic {
        width: 100%;
        background-color: #ffffff;
        color: #4b4c4d;
    }
    .footer-basic .copyright {
        margin-top: 5px;
        text-align: center;
        font-size: 13px;
        color: #aaa;
        margin-bottom: 5px;
    }
</style>
