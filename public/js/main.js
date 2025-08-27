/**
* Template Name: NiceAdmin
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Updated: Apr 20 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle (handled later with desktop/mobile logic)
   * initial simple handler removed to avoid conflict with mobile behavior
   */

  /**
   * Search bar toggle
   */
  if (select('.search-bar-toggle')) {
    on('click', '.search-bar-toggle', function(e) {
      select('.search-bar').classList.toggle('search-bar-show')
    })
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate tooltips
   */
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  /**
   * Initiate quill editors
   */
  if (select('.quill-editor-default')) {
    new Quill('.quill-editor-default', {
      theme: 'snow'
    });
  }

  if (select('.quill-editor-bubble')) {
    new Quill('.quill-editor-bubble', {
      theme: 'bubble'
    });
  }

  if (select('.quill-editor-full')) {
    new Quill(".quill-editor-full", {
      modules: {
        toolbar: [
          [{
            font: []
          }, {
            size: []
          }],
          ["bold", "italic", "underline", "strike"],
          [{
              color: []
            },
            {
              background: []
            }
          ],
          [{
              script: "super"
            },
            {
              script: "sub"
            }
          ],
          [{
              list: "ordered"
            },
            {
              list: "bullet"
            },
            {
              indent: "-1"
            },
            {
              indent: "+1"
            }
          ],
          ["direction", {
            align: []
          }],
          ["link", "image", "video"],
          ["clean"]
        ]
      },
      theme: "snow"
    });
  }

  /**
   * Initiate TinyMCE Editor
   */

  const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

  tinymce.init({
    selector: 'textarea.tinymce-editor',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
    editimage_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    link_list: [{
        title: 'My page 1',
        value: 'https://www.tiny.cloud'
      },
      {
        title: 'My page 2',
        value: 'http://www.moxiecode.com'
      }
    ],
    image_list: [{
        title: 'My page 1',
        value: 'https://www.tiny.cloud'
      },
      {
        title: 'My page 2',
        value: 'http://www.moxiecode.com'
      }
    ],
    image_class_list: [{
        title: 'None',
        value: ''
      },
      {
        title: 'Some class',
        value: 'class-name'
      }
    ],
    importcss_append: true,
    file_picker_callback: (callback, value, meta) => {
      /* Provide file and text for the link dialog */
      if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', {
          text: 'My text'
        });
      }

      /* Provide image and alt text for the image dialog */
      if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', {
          alt: 'My alt text'
        });
      }

      /* Provide alternative source and posted for the media dialog */
      if (meta.filetype === 'media') {
        callback('movie.mp4', {
          source2: 'alt.ogg',
          poster: 'https://www.google.com/logos/google.jpg'
        });
      }
    },
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    contextmenu: 'link image table',
    skin: useDarkMode ? 'oxide-dark' : 'oxide',
    content_css: useDarkMode ? 'dark' : 'default',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
  });

  /**
   * Initiate Bootstrap validation check
   */
  var needsValidation = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(needsValidation)
    .forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })

  /**
   * Initiate Datatables
   */
  const datatables = select('.datatable', true)
  datatables.forEach(datatable => {
    new simpleDatatables.DataTable(datatable, {
      perPageSelect: [5, 10, 15, ["All", -1]],
      columns: [{
          select: 2,
          sortSequence: ["desc", "asc"]
        },
        {
          select: 3,
          sortSequence: ["desc"]
        },
        {
          select: 4,
          cellClass: "green",
          headerClass: "red"
        }
      ]
    });
  })

  /**
   * Autoresize echart charts
   */
  const mainContainer = select('#main');
  if (mainContainer) {
    setTimeout(() => {
      new ResizeObserver(function() {
        select('.echart', true).forEach(getEchart => {
          echarts.getInstanceByDom(getEchart).resize();
        })
      }).observe(mainContainer);
    }, 200);
  }

  // Gestion du menu actif persistant
  document.querySelectorAll('.sidebar-nav .nav-link').forEach(function(link) {
    link.addEventListener('click', function() {
      if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
        localStorage.setItem('activeMenu', this.getAttribute('href'));
      }
    });
  });

  // Helper: normalize paths for reliable matching
  function normalizePath(p) {
    if (!p) return '/';
    try {
  return p.replace(/\\/g, '/').replace(/\/+$/, '') || '/';
    } catch (e) {
      return p;
    }
  }

  // Set active menu item based on current URL (handles submenus)
  function setActiveMenuByUrl() {
    var url = normalizePath(window.location.pathname);
    var found = false;

    // clear previous states
    document.querySelectorAll('.sidebar-nav .nav-link, .sidebar-nav .nav-content a').forEach(function(el) {
      el.classList.remove('active');
    });

    // exact match on submenu links
    document.querySelectorAll('.sidebar-nav .nav-content a[href]').forEach(function(sublink) {
      var href = normalizePath(sublink.getAttribute('href'));
    if (href === url) {
        sublink.classList.add('active');
        // open parent collapse using bootstrap
        var navContent = sublink.closest('.nav-content');
        if (navContent && navContent.id) {
          var collapseEl = document.getElementById(navContent.id);
          if (collapseEl) {
            var bs = bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl, {toggle: false});
            bs.show();
          }
        }
        var parentToggle = null;
        if (navContent && navContent.id) {
          parentToggle = document.querySelector('[data-bs-target="#' + navContent.id + '"]');
        }
        if (!parentToggle && navContent) parentToggle = navContent.previousElementSibling;
        if (parentToggle && parentToggle.classList.contains('nav-link')) {
          parentToggle.classList.add('active');
          parentToggle.classList.remove('collapsed');
          parentToggle.setAttribute('aria-expanded', 'true');
        }
        localStorage.setItem('activeMenu', sublink.getAttribute('href'));
        found = true;
      }
    });

    // exact match on top-level links
    if (!found) {
      document.querySelectorAll('.sidebar-nav > .nav-item > .nav-link[href]').forEach(function(link) {
        var href = normalizePath(link.getAttribute('href'));
  if (href === url) {
          link.classList.add('active');
          localStorage.setItem('activeMenu', link.getAttribute('href'));
          found = true;
        }
      });
    }

    // fallback: subpath match for submenu (e.g. /clients/create -> /clients)
    if (!found) {
      document.querySelectorAll('.sidebar-nav .nav-content a[href]').forEach(function(sublink) {
        var href = normalizePath(sublink.getAttribute('href'));
    if (href !== '/' && url.indexOf(href) === 0) {
          sublink.classList.add('active');
          var navContent = sublink.closest('.nav-content');
          if (navContent && navContent.id) {
            var collapseEl = document.getElementById(navContent.id);
            if (collapseEl) {
              var bs = bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl, {toggle: false});
              bs.show();
            }
          }
          var parentToggle = null;
          if (navContent && navContent.id) {
            parentToggle = document.querySelector('[data-bs-target="#' + navContent.id + '"]');
          }
          if (!parentToggle && navContent) parentToggle = navContent.previousElementSibling;
          if (parentToggle && parentToggle.classList.contains('nav-link')) {
            parentToggle.classList.add('active');
            parentToggle.classList.remove('collapsed');
            parentToggle.setAttribute('aria-expanded', 'true');
          }
          localStorage.setItem('activeMenu', sublink.getAttribute('href'));
          found = true;
        }
      });
    }

    if (!found) {
      localStorage.removeItem('activeMenu');
    }
  }

  function handleResizeForSidebar() {
    // Always recompute active menu; CSS controls visibility of icons/text on small screens
    setActiveMenuByUrl();
  }

  // When toggling the sidebar via the hamburger, recompute active states so they appear when opened
  var toggler = document.querySelector('.toggle-sidebar-btn');
  if (toggler) {
  // Ensure accessibility attributes
  try { toggler.setAttribute('role', 'button'); toggler.tabIndex = 0; } catch (e) {}
  // Ensure pointer events
  toggler.style.pointerEvents = 'auto';

  // Debug: log presence
  console.log('[menu-debug] toggler found:', toggler, 'innerWidth=', window.innerWidth);

    function toggleSidebarHandler(e) {
      e && e.preventDefault && e.preventDefault();
      e && e.stopPropagation && e.stopPropagation();
        var isMobile = window.innerWidth <= 600;
        if (isMobile) {
          // mobile: toggle overlay open class only
          document.body.classList.toggle('sidebar-open');
          // ensure the desktop compact class isn't conflicting
          document.body.classList.remove('toggle-sidebar');
        } else {
          // desktop: toggle compact sidebar (icons-only)
          document.body.classList.toggle('toggle-sidebar');
          // ensure mobile overlay class isn't present on desktop
          document.body.classList.remove('sidebar-open');
        }
      // recompute active after the change
      setTimeout(setActiveMenuByUrl, 120);
    }

    toggler.addEventListener('click', function(e){ console.log('[menu-debug] click event on toggler'); toggleSidebarHandler(e); });
    toggler.addEventListener('touchstart', function(e){ console.log('[menu-debug] touchstart on toggler'); toggleSidebarHandler(e); }, {passive:false});
    toggler.addEventListener('keydown', function(e){ if(e.key === 'Enter' || e.key === ' ') { console.log('[menu-debug] keydown toggler', e.key); toggleSidebarHandler(e); } });
    // Also listen on document for delegated touches (fallback)
    document.addEventListener('touchstart', function(e){
      var t = e.target.closest && e.target.closest('.toggle-sidebar-btn');
      if (t) { console.log('[menu-debug] delegated touchstart'); toggleSidebarHandler(e); }
    }, {passive:false});
  }

  // Init and handlers for active menu (main + submenus)
  document.addEventListener('DOMContentLoaded', function() {
    // Set initial active according to current URL or localStorage
    setActiveMenuByUrl();

    // Ensure on small screens the sidebar is closed by default and only hamburger toggles it
    if (window.innerWidth <= 600) {
      document.body.classList.remove('toggle-sidebar');
      document.body.classList.remove('sidebar-open');
    }

    // Persist and handle clicks on submenu items
    document.querySelectorAll('.sidebar-nav .nav-content a').forEach(function(link) {
      link.addEventListener('click', function() {
        localStorage.setItem('activeMenu', link.getAttribute('href'));
  // close mobile overlay on small screens to reveal content
  if (window.innerWidth <= 600) document.body.classList.remove('sidebar-open');
      });
    });

    // Persist clicks on top-level links with href
    document.querySelectorAll('.sidebar-nav > .nav-item > .nav-link[href]').forEach(function(link) {
      link.addEventListener('click', function() {
        localStorage.setItem('activeMenu', link.getAttribute('href'));
  if (window.innerWidth <= 600) document.body.classList.remove('sidebar-open');
      });
    });

    // Ensure proper behavior on resize
    window.addEventListener('resize', function() {
      // If we shrink to mobile size, always close the sidebar and rely on hamburger
      if (window.innerWidth <= 600) {
        document.body.classList.remove('toggle-sidebar');
        // keep sidebar closed when resizing into mobile unless user opens it
        document.body.classList.remove('sidebar-open');
      }
      handleResizeForSidebar();
    });

    // Fallback: if on mobile the existing toggler isn't visible or clickable, create a temporary floating hamburger
    if (window.innerWidth <= 600) {
      try {
        var mainToggler = document.querySelector('.toggle-sidebar-btn');
        var togglerVisible = mainToggler && mainToggler.getBoundingClientRect && mainToggler.getBoundingClientRect().width > 0;
        if (!togglerVisible) {
          var fb = document.getElementById('mobile-hamburger-test');
          if (!fb) {
            fb = document.createElement('button');
            fb.id = 'mobile-hamburger-test';
            fb.setAttribute('aria-label', 'Ouvrir le menu');
            fb.style.position = 'fixed';
            fb.style.left = '12px';
            fb.style.top = '8px';
            fb.style.width = '44px';
            fb.style.height = '44px';
            fb.style.borderRadius = '8px';
            fb.style.background = '#ffffff';
            fb.style.border = '1px solid rgba(0,0,0,0.06)';
            fb.style.zIndex = '2000';
            fb.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
            fb.style.display = 'flex';
            fb.style.alignItems = 'center';
            fb.style.justifyContent = 'center';
            fb.innerHTML = '<i class="bi bi-list" style="font-size:20px;color:#2563eb"></i>';
            document.body.appendChild(fb);
            fb.addEventListener('click', function(e){ e.preventDefault(); e.stopPropagation(); document.body.classList.toggle('sidebar-open'); setTimeout(setActiveMenuByUrl,120); });
            fb.addEventListener('touchstart', function(e){ e.preventDefault(); e.stopPropagation(); document.body.classList.toggle('sidebar-open'); setTimeout(setActiveMenuByUrl,120); }, {passive:false});
          }
        }
      } catch (err) {
        console.error('[menu-debug] fallback creation failed', err);
      }
    }
  });

  // Si aucun menu actif n'est stocké, utilise l'URL courante
  document.addEventListener('DOMContentLoaded', function() {
    if (!localStorage.getItem('activeMenu')) {
      // Cherche un lien qui correspond exactement à l'URL courante (sans query ni hash)
      var path = window.location.pathname;
      var found = false;
      document.querySelectorAll('.sidebar-nav .nav-link, .sidebar-nav .nav-content a').forEach(function(link) {
        if (link.getAttribute('href') === path) {
          localStorage.setItem('activeMenu', path);
          found = true;
        }
      });
      // Si aucun lien ne correspond, ne rien faire
    }
  });

  // Sidebar hover pour ouvrir/fermer
  let sidebar = document.getElementById('sidebar');
  if (sidebar) {
    sidebar.addEventListener('mouseenter', function() {
      document.body.classList.remove('toggle-sidebar');
    });
    sidebar.addEventListener('mouseleave', function() {
      document.body.classList.add('toggle-sidebar');
    });
  }

})();