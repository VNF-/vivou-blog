(function () {
    // create visionShortcodes plugin
    tinymce.create("tinymce.plugins.visionShortcodes", {
        init: function (ed, url) {
            ed.addCommand("visionPopup", function (a, params) {
                var popup = params.identifier;

                // load thickbox
                tb_show("Insert Shortcode", url + "/vision_popup.php?popup=" + popup + "&width=" + 800);
            });
        },
        createControl: function (btn, e) {
            if (btn == "vision_button") {
                var a = this;

                // adds the tinymce button
                btn = e.createSplitButton("vision_button", {
                    title: "Insert Shortcode",
                    image: "https://s3.amazonaws.com/Plugin-Vision/btn.png",
                    icons: false
                });



                // adds the dropdown to the button
                btn.onRenderMenu.add(function (c, b) {
                
                	//# start: modified by Arlind Nushi
                    a.addWithPopup(b, "Columns", "lab-columns");
                    a.addImmediate(b, "Breadcrumb", "[lab_breadcrumb]");
                    a.addImmediate(b, "Clear Row", "[lab_clear]");
                    a.addWithPopup(b, "Alert Message", "lab-alert");
                    a.addWithPopup(b, "Button", "lab-button");
                    a.addWithPopup(b, "Pricing Box", "lab-pricing-box");
                    a.addWithPopup(b, "Tabs", "lab-tabs");
                    //# end: modified by Arlind Nushi
                    
                   /* a.addWithPopup(b, "Accordions", "accordions");
                    a.addWithPopup(b, "Buttons", "button");
                    a.addWithPopup(b, "Blog Posts", "blog-posts");
					a.addWithPopup(b, "Content Boxes", "content-boxes");
                    a.addWithPopup(b, "Dividers", "dividers");
					a.addWithPopup(b, "Drop Caps", "dropcaps" );
					a.addWithPopup(b, "Email Encoder", "mailto");
					a.addWithPopup(b, "Highlight Text", "highlight");
                    a.addWithPopup(b, "Icons", "icons");
                    a.addWithPopup(b, "Icons - Minimal", "icons-mono");
                    a.addWithPopup(b, "Notification Boxes", "notifications");
					a.addWithPopup(b, "Pricing Boxes", "pricing-box");
					a.addWithPopup(b, "Pull Quotes", "pull-quotes");
					a.addWithPopup(b, "Social Icons", "social-icons");
                    a.addWithPopup(b, "Tabs", "tabs");
                    a.addWithPopup(b, "Testimonials", "testimonials");
                    a.addWithPopup(b, "Text Styles", "text-styles");*/
                });

                return btn;
            }

            return null;
        },
        addWithPopup: function (ed, title, id) {
            ed.add({
                title: title,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("visionPopup", false, {
                        title: title,
                        identifier: id
                    })
                }
            })
        },
        addImmediate: function (ed, title, sc) {
            ed.add({
                title: title,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("mceInsertContent", false, sc)
                }
            })
        },
        getInfo: function () {
            return {
                longname: 'Vision Shortcodes',
                author: 'TrueThemes',
                authorurl: 'http://themeforest.net/user/truethemes/',
                infourl: 'http://wiki.moxiecode.com/',
                version: "1.0"
            }
        }
    });

    // add visionShortcodes plugin
    tinymce.PluginManager.add("visionShortcodes", tinymce.plugins.visionShortcodes);
})();