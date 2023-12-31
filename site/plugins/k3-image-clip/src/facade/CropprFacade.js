import Croppr from 'croppr'
import aspectRatioFit from '../helpers/aspectRatioFit.js'

/**
 * Facade to Croppr
 * Validation and Bugfixes to link Croppr with Kirby's Panel
 */
export default class {
  /**
   * Constructor
   * @param {Element} el - The image to work with
   * @param {Object} originalDimensions - From file on disk
   * @param {Object} saved - Crop data from disk
   * @param {Object} clip - Blueprint options
   * @param {Object} events
   */
  constructor ({ el, originalDimensions, saved, clip, events }) {
    this.el = el
    this.original_dimensions = originalDimensions
    this.saved = saved
    this.min_width = clip ? clip.minwidth : null
    this.min_height = clip ? clip.minheight : null
    this.max_width = clip ? clip.maxwidth : null
    this.max_height = clip ? clip.maxheight : null
    this.limit_width = null
    this.limit_height = null
    this.ratio = clip ? clip.ratio : null
    this.events = events

    this.validate()
    this.cropInstance = this.init()
  }

  /**
   * reset all of the croppr instance and adjust to new environment
   * @param {Object} position - last known position of crop area
   */
  reset ({ position }) {
    this.cropInstance.destroy()
    this.saved = position
    this.cropInstance = this.init()
  }

  /**
   * Initiate Croppr
   * @returns {Croppr} - Croppr Instance
   */
  init () {
    const options = {
      returnMode: 'raw',
      onInitialize: (instance) => {
        // image width for factor calculations because they are wrong in Croppr
        const image = document.getElementsByClassName('croppr-image')[0]
        image.addEventListener('load', (event) => {
          this.image = event.target
          this.factor_w = this.original_dimensions.width / event.target.clientWidth
          this.factor_h = this.original_dimensions.height / event.target.clientHeight
          this.setStartPosition()
          this.setSelectorBoundaries()
        }, false)
      },
      ...this.events
    }

    if (this.min_width && this.min_height) {
      options.aspectRatio = (this.ratio === 'fixed') ? this.min_height / this.min_width : null
      options.minSize = [this.min_width, this.min_height, 'px']
      this.limit_width = this.min_width
      this.limit_height = this.min_height
    }

    if (this.max_width && this.max_height) {
      options.aspectRatio = (this.ratio === 'fixed') ? this.max_height / this.max_width : null
      options.maxSize = [this.max_width, this.max_height, 'px']
      this.limit_width = this.max_width
      this.limit_height = this.max_height
    }

    return new Croppr(this.el, options)
  }

  /**
   * Returns the crop area coordinates
   * @returns {Object} - Coordinates in "real" values on original image
   */
  getCropArea () {
    const coord = this.cropInstance.getValue()
    const area = {
      width: this.roundSize(coord.width * this.factor_w, this.limit_width),
      height: this.roundSize(coord.height * this.factor_h, this.limit_height)
    }

    area.left = this.adjustPosition(coord.x * this.factor_w, area.width, this.original_dimensions.width)
    area.top = this.adjustPosition(coord.y * this.factor_h, area.height, this.original_dimensions.height)

    return area
  }

  /**
   * Moves the crop selector to a start position
   */
  setStartPosition () {
    let reference = {}
    if (this.saved) {
      // set to position of saved cropped image
      reference = {
        width: Math.round(this.saved.width / this.factor_w),
        height: Math.round(this.saved.height / this.factor_h),
        left: Math.round(this.saved.left / this.factor_w),
        top: Math.round(this.saved.top / this.factor_h)
      }
    } else {
      reference = {
        width: (this.max_width ? this.max_width : this.original_dimensions.width) / this.factor_w,
        height: (this.max_height ? this.max_height : this.original_dimensions.height) / this.factor_h,
        left: 0,
        top: 0
      }
    }

    // set size and position
    this.cropInstance.resizeTo(reference.width, reference.height)
    this.cropInstance.moveTo(reference.left, reference.top)
  }

  /**
   * set size of crop selector to max/min values according to current image size
   * current image size is only known after initialisation
   */
  setSelectorBoundaries () {
    if (this.max_width && this.max_height) {
      this.cropInstance.options.maxSize = {
        width: this.max_width / this.factor_w,
        height: this.max_height / this.factor_h
      }
    }
    if (this.min_width && this.min_height) {
      this.cropInstance.options.minSize = {
        width: this.min_width / this.factor_w,
        height: this.min_height / this.factor_h
      }
    }
  }

  /**
   * Validates Options vs Image
   * @throws {Error}
   */
  validate () {
    if (this.min_width && this.original_dimensions.width < this.min_width) {
      throw new Error(`Image width (${this.original_dimensions.width}px) must be at least ${this.min_width}px`)
    }

    if (this.min_height && this.original_dimensions.height < this.min_height) {
      throw new Error(`Image height (${this.original_dimensions.height}px) must be at least ${this.min_height}px`)
    }

    if (this.min_width && this.min_height && this.max_width &&
      this.max_height && this.ratio === 'fixed' &&
      (this.min_width / this.min_height) !== (this.max_width / this.max_height)) {
      throw new Error('Ratio must be same for min and max')
    }
  }

  /**
   *  Return the rounded coordinates
   *  If 1px or less from defined limit, round to the limit
   * @param value
   * @param limit
   * @returns {number|*}
   */
  roundSize (value, limit = null) {
    return (limit && limit - value >= -1 && limit - value <= 1) ? limit : Math.round(value)
  }

  /**
   *  Return the adjusted position
   *  Corrects for 1px rounding errors and makes sure selection is always inside image
   * @param position
   * @param size
   * @param limit
   * @returns {number}
   */
  adjustPosition (position, size, limit) {
    return (position + size > limit) ? limit - size : Math.round(position)
  }
}
