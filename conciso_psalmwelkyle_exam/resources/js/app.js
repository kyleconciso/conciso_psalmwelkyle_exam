import { createApp, h } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { toast } from "./toast";

import "../css/app.css";
import "./bootstrap";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

router.on("finish", () => {
    const page = router.page.props;

    if (page.jetstream?.flash?.banner) {
        toast.showToast(page.jetstream.flash.banner, "success");
    } else if (page.flash?.success) {
        toast.showToast(page.flash.success, "success");
    } else if (page.flash?.error) {
        toast.showToast(page.flash.error, "error");
    }
});
