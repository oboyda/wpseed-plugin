import Utils from '../Utils';
import View from './View';

class NavBar extends View 
{
    constructor(props)
    {
        super(props, {
            app: null,
            gridSizeX: 0,
            gridSizeY: 0
        }, {
            set_state: true
        });

        // this.state = {
        // };

        this.handleOpenGridSetup = this.handleOpenGridSetup.bind(this);
    }

    // _componentDidMount()
    // {

    // }

    // _componentDidMount()
    // {
        
    // }

    handleOpenGridSetup()
    {
        Utils.dispatchEvent('grid__open_grid_setup');
    }

    render()
    {
        return (
            <div className={this.getViewClass()}>
                <div className='nav-cont nav-1'>
                    <button className='app-btn btn-2' onClick={this.handleOpenGridSetup}>{indexVars.strings.navBar.btn_set_canvas_label}</button> 
                    {/* <span className='grid-size-label'>{this.grid.getSizeX(false)+'x'+this.grid.getSizeY(false)}</span> */}
                </div>
                <div className='nav-cont nav-2'>
                    
                </div>
                <div className='nav-cont nav-3'>
                    <button className='app-btn btn-2' onClick={this.handleOpenGridSetup}>{indexVars.strings.navBar.btn_continue_label}</button> 
                </div>
            </div>
        );
    }
}

export default NavBar;
