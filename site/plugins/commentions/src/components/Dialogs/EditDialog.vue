<template>
  <k-dialog class="k-commentions-editdialog"
    ref="dialog"
    :button="$t('save')"
    :notification="notification"
    size="large"
    theme="positive"
    @submit="$refs.form.submit()"
  >
    <k-form
      ref="form"
      :fields="fields"
      v-model="commention"
      @input="input"
      @submit="submit"
    />
  </k-dialog>
</template>

<script>
export default {
  data() {
    return {
      notification: null,
      commention: {
        uid: null,
        name: null,
        timestamp: null,
        email: null,
        avatar: null,
        website: null,
        type: null,
        text: null,
        source: null,
      }
    };
  },

  computed: {
    fields() {
      return {
        name: {
          label: this.$t('commentions.section.edit.name'),
          type: "text",
          icon: "user",
          preselect: true,
        },
        website: {
          label: this.$t('commentions.section.edit.website'),
          type: "url",
        },
        email: {
          label: this.$t('commentions.section.edit.email'),
          type: "email",
        },
        avatar: {
          label: this.$t('commentions.section.edit.avatar'),
          type: "url",
        },
        timestamp: {
          label: this.$t('commentions.section.edit.timestamp'),
          type: "date",
          required: true,
          time: {step: {size: 1, unit: "minute"}}
        },
        type: {
          label: this.$t('commentions.section.edit.type'),
          type: "select",
          required: true,
          icon: "template",
          empty: false,
          options: [
            {value: "comment", text: "Comment"},
            {value: "webmention", text: "Webmention"},
            {value: "reply", text: "Reply"},
            {value: "like", text: "Like"},
            {value: "repost", text: "Repost"},
            {value: "bookmark", text: "Bookmark"},
            {value: "read", text: "Read"},
            {value: "rsvpyes", text: "RSVP yes"},
            {value: "rsvpno", text: "RSVP no"},
            {value: "rsvpmaybe", text: "RSVP maybe"},
          ],
        },
        text: {
          label: this.$t('commentions.section.edit.text'),
          type: "textarea",
          buttons: false,
          size: "small",
        },
        source: {
          label: this.$t('commentions.section.edit.source'),
          type: "url",
        },
      };
    }
  },

  methods: {
    open(item, pageid) {
      this.pageid = pageid;
      this.commention = {
        uid: item.uid,
        name: item.name,
        timestamp: item.timestamp,
        email: item.email,
        avatar: item.avatar,
        website: item.website,
        type: item.type,
        text: item.text,
        source: item.source,
      };
      this.$refs.dialog.open();
      this.input(item);
      console.log(this.notification);
    },

    input(formdata) {
      if (formdata.type === 'comment') {
        this.fields.source.disabled = true;
        this.fields.source.required = false;
      } else {
        this.fields.source.disabled = false;
        this.fields.source.required = true;
      }
    },

    submit() {
      if (this.fields.source.required && !this.commention.source) {
        this.$refs.dialog.error("Source URL is required for webmentions");
        return;
      }
      const data = {
        name: this.commention.name,
        timestamp: this.commention.timestamp,
        email: this.commention.email,
        avatar: this.commention.avatar,
        website: this.commention.website,
        type: this.commention.type,
        text: this.commention.text,
        source: this.commention.source,
      };
      this.$refs.dialog.close();
      this.$emit("submit", [this.pageid, this.commention.uid, data]);
      this.commention = null;
    }
  }

};
</script>

<style lang="scss">
.k-commentions-editdialog .k-fieldset .k-grid {
  grid-row-gap: 1rem;
}
</style>
