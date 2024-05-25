/**
 * Software Object that adds/remove a class string based on a width breakpoint on the screen
 */
class ResponsiveElement
{
    constructor(elementSelector, widthBreakpoint, classStringForLargeWidth, classStringForSmallWidth)
    {
        // HTML element to watch on
        this.element = $(elementSelector);

        // Screen width value where something will change
        this.widthBreakpoint = widthBreakpoint;

        // HTML String representing classes to be added or removed
        this.classStringForLargeWidth = classStringForLargeWidth;
        this.classStringForSmallWidth = classStringForSmallWidth;

        // Call change orientation as soon as it is generated
        this.change_orientation_on_width();

        // Append an event listener of window element to this button
        $(window).on("resize", this.change_orientation_on_width.bind(this));
    }

    change_orientation_on_width()
    {
        /** Remove a class string and add another when required */
        if ($(window).width() < this.widthBreakpoint)
        {
            this.element.removeClass(this.classStringForLargeWidth).addClass(this.classStringForSmallWidth);
        }

        else
        {
            this.element.removeClass(this.classStringForSmallWidth).addClass(this.classStringForLargeWidth);
        }
    }
}