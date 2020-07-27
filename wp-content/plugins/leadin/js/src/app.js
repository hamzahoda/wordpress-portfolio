import $ from 'jquery';

import Raven, { configureRaven } from './lib/Raven';
import { addExternalLinks } from './menu';
import { createIframe } from './iframe/iframe';

function main() {
  $(document).ready(() => {
    addExternalLinks();
    createIframe();
  });
}

configureRaven();
Raven.context(main);
