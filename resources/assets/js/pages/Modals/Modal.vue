<template>
    <transition name="modal">
        <div class="modal is-active">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">
                    <slot name="header"></slot>
                    </p>
                    <slot name="header-button"></slot>
                </header>
                <section class="modal-card-body">
                    <md-card>
                        <md-card-content>
                            <slot></slot>
                        </md-card-content>
                    </md-card>
                </section>
                <footer class="modal-card-foot">
                    <slot name="footer"></slot>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'modal'
}
</script>