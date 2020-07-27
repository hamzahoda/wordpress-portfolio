/**
 * Certy Options
 */

var navStiky = false;
if(certy_vars_from_WP.enable_sticky == 1) { navStiky = true; }


var certy = {
    vars: {
        // Set theme rtl mode
        rtl: false,

        // Set theme primary color
        themeColor: certy_vars_from_WP.themeColor,

        // Set middle screen size, must have the same value as in the _variables.scss
        screenMd: '992px'
    },

    nav: {
        height: 'auto', // use 'auto' or some fixed value, for example 480px
        arrow: false, // activate arrow to scroll down menu items,
        sticky: {
            top: "-1px", // sticky position from top
            active: navStiky // activate sticky property on window scroll
        },
        tooltip: {
            active: true
        }
    },

    sideBox: {
        sticky: {
            top: "20px", // sticky position from top
            active: false // activate sticky property on window scroll
        }
    },

    progress: {
        animation: true, // animate on window scroll
        textColor: 'inherit', // set text color
        trailColor: 'rgba(0,0,0,0.07)' // set trail color
    }
};