<aside class="sidenav-main sidenav-light sidenav-active-square scrollbar nav-lock nav-expanded">

    <div class="brand-sidebar">

        <h1 class="logo-wrapper">
            {{-- Sua Logo Aqui --}}
        </h1>

    </div>

    <ul id="slide-out"
        class="scrollbar scrollbar-primary sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow"
        data-menu="menu-navigation" data-collapsible="menu-accordion">
        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect waves-cyan">
                <i class="material-icons">home</i>Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('imports') }}" class="waves-effect waves-cyan">
                <i class="material-icons">upload</i>
                Importação de Arquivos
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="waves-effect waves-cyan collapsible-header" tabindex="0">
                <i class="material-icons">pie_chart</i>
                Relatórios
            </a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li>
                        <a href="{{ route('reports.nfe') }}">
                            <i class="material-icons"></i>
                            Notas Fiscais
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.fornecedores') }}" class="waves-effect waves-cyan">
                            <i class="material-icons"></i> Fornecedores
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.sped') }}" class="waves-effect waves-cyan">
                            <i class="material-icons"></i>
                            Sped Fiscal
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ url('reports/sped/nao_escrituradas') }}">
                            <i class="material-icons"></i>
                            Notas não escrituradas
                        </a>
                    </li> --}}
                    {{-- <li><a href="#">Duplicatas</a></li> --}}
                </ul>
            </div>
        </li>
    </ul>

    <div id="footer" style="position: absolute; z-index: 9999; bottom: 0; left: 0;">
        <button type="button" class="btn waves-effect blue" id="shell_exec">
            <i class="material-icons">code</i>
        </button>
    </div>

    <a href="#" data-target="slide-out"
        class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only">
        <i class="material-icons">menu</i>
    </a>

</aside>
