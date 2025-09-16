import "../assets/js/custom";
import "../assets/js/switcher-styles";

import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'

Alpine.plugin(Clipboard)
Livewire.start()
