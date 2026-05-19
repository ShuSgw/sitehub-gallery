import.meta.glob("../images/**/*", { eager: true });
import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
