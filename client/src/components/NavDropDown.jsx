import React, { useState } from 'react';
import { RiArrowDropDownLine, RiArrowDropUpLine } from 'react-icons/ri';

function NavDropDown({ options, selected }) {
    const [isOpen, setIsOpen] = useState(false);
    const [selectedOption, setSelectedOption] = useState("All");
    const [expandedOption, setExpandedOption] = useState(null);

    const toggleDropdown = () => setIsOpen(!isOpen);

    const handleOptionClick = (option) => {
        if (option.subOptions && option.subOptions.length > 0) {
            if (expandedOption === option.label) {
                setExpandedOption(null);
            } else {
                setExpandedOption(option.label);
            }
            return;
        }
        selected(option.label);
        setSelectedOption(option.label);
        setIsOpen(false);
    };

    const renderOptions = (options) => {
        return options.map((option, index) => (
            <li key={index} className="bg-white cursor-pointer m-1 rounded-[10px] border-b border-gray-300 text-center ">
                <div className='flex relative' onClick={() => handleOptionClick(option)}>
                    {option.label}
                    {option.subOptions && option.subOptions.length > 0 && (
                        expandedOption === option.label ? <RiArrowDropUpLine className='text-[1.6rem]'/> : <RiArrowDropDownLine className='text-[1.6rem]'/>
                    )}
                </div>
                {expandedOption === option.label && option.subOptions && option.subOptions.length > 0 && (
                    <ul className=" absolute left-[130px]">
                        {option.subOptions.map((subOption, subIndex) => (
                            <li key={subIndex} className="bg-gray-200 min-w-[100px]  w-full cursor-pointer m-1 rounded-[10px] border-b border-gray-200 "
                                onClick={(e) => {
                                    e.stopPropagation();
                                    selected(subOption);
                                    setSelectedOption(subOption);
                                    setIsOpen(false);
                                    setExpandedOption(null);
                                }}>
                                {subOption}
                            </li>
                        ))}
                    </ul>
                )}
            </li>
        ));
    };

    return (
        <div>
            <div>
                <button className=" rounded-[20px] px-6 py-2 flex" onClick={toggleDropdown}>{selectedOption} {isOpen ? <RiArrowDropUpLine className='text-[1.6rem]'/>:<RiArrowDropDownLine className='text-[1.6rem]'/> }</button>
            </div>
            {isOpen && (
                <ul className="absolute">
                    {renderOptions(options)}
                </ul>
            )}
        </div>
    );
}
export default NavDropDown;
