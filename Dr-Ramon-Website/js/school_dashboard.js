let Dashboard = (() => {
    let global = {
      tooltipOptions: {
        placement: "right"
      },
      menuClass: ".c-menu"
    };
    let menuChangeActive = el => {
      let hasSubmenu = $(el).hasClass("has-submenu");
      $(global.menuClass + " .is-active").removeClass("is-active");
      $(el).addClass("is-active");
  
      // if (hasSubmenu) {
      // 	$(el).find("ul").slideDown();
      // }
    };
    let sidebarChangeWidth = () => {
      let $menuItemsTitle = $("li .menu-item__title");
      $("body").toggleClass("sidebar-is-reduced sidebar-is-expanded");
      $(".hamburger-toggle").toggleClass("is-opened");
      if ($("body").hasClass("sidebar-is-expanded")) {
        $('[data-toggle="tooltip"]').tooltip("destroy");
      } else {
        $('[data-toggle="tooltip"]').tooltip(global.tooltipOptions);
      }
    };
    return {
      init: () => {
        $(".js-hamburger").on("click", sidebarChangeWidth);
        $(".js-menu li").on("click", e => {
          menuChangeActive(e.currentTarget);
        });
        $('[data-toggle="tooltip"]').tooltip(global.tooltipOptions);
      }
    };
  })();
  Dashboard.init();